<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CompanyCountryEnum;
use App\Enums\ObjectLanguageTypeEnum;
use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Controllers\SystemConfigController;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Language;
use App\Models\ObjectLanguage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Utils\Paginator;
use Throwable;

class PostController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Post::query();
        $this->table = (new Post())->getTable();

        View::share('title', ucwords($this->table));
    }

    public function index()
    {
        $data = $this->model->get();

        return view("admin.$this->table.index", [
            'data' => $data,
        ]);
    }

    public function create()
    {
//        cache()->forget('configs');
        $configs = SystemConfigController::getAndCache();
        $currencies = $configs['currencies'];
        $countries = $configs['countries'];

        return view("admin.$this->table.create", [
            'currencies' => $currencies,
            'countries' => $countries,
        ]);
    }

    public function importCsv(Request $request): JsonResponse
    {
        try {
            Excel::import(new PostImport, $request->file('file'));

            return $this->successResponse();
        } catch (Throwable $e) {
            return $this->errorResponse();
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $arr = $request->only([
                'job_title',
                'city',
                'status',
                'company_id',
                "district",
                "remotable",
                "is_part_time",
                "min_salary",
                "max_salary",
                "currency_salary",
                "requirement",
                "start_date",
                "end_date",
                "number_applicants",
                "status",
                "is_pinned",
                "slug",
            ]);

            $companyName = $request->get('company');
            if(!empty($companyName)){
                $arr['company_id'] = Company::firstOrCreate(['name' => $companyName])->id;
            }

            if($request->has('remotables')){
                $remotable = $request->get('remotables');
                if(!empty($remotable['remote']) && !empty($remotable['office'])){
                    $arr['remotable'] = PostRemotableEnum::DYNAMIC;
                } else if(!empty($remotable['remote'])){
                    $arr['remotable'] = PostRemotableEnum::REMOTE_ONLY;
                } else {
                    $arr['remotable'] = PostRemotableEnum::OFFICE_ONLY;
                }
            }

            if($request->has('is_part_time')){
                $arr['is_part_time'] = 1;
            }

            $post = Post::query()->create($arr);

            $languages = $request->get('languages');

            foreach ($languages as $language) {
                ObjectLanguage::query()->create([
                   'language_id' => $language,
                   'object_id' => $post->id,
                   'object_type' => Post::class,
                ]);
            }

            DB::commit();
            return $this->successResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
