<?php

namespace App\Http\Controllers\Applicant;

use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Config;
use App\Models\Language;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $searchCities = $request->get('cities', []);
        $remotable    = $request->get('remotable');
        $is_part_time = $request->get('is_part_time', 0);
        $arrCity      = getAndCachePostCities();
        $configs      = Config::getAndCache(0);
        $minSalary    = $request->get('min_salary', $configs['filter_min_salary']);
        $maxSalary    = $request->get('max_salary', $configs['filter_max_salary']);

        $query = Post::query()->with([
            'languages',
            'company' => function ($q) {
                return $q->select(
                    'id',
                    'name',
                    'logo',
                );
            },
        ])
            ->approved()
            ->orderByDesc('is_pinned')
            ->orderByDesc('id');

        if (!empty($searchCities)) {
            $query->where(function ($q) use ($searchCities) {
                foreach ($searchCities as $searchCity) {
                    $q->orWhere('city', 'like', '%' . $searchCity . '%');
                }
                $q->orWhereNull('city');
            });
        }

        if (!empty($is_part_time)) {
            $query->where('is_part_time', $is_part_time);
        }

        if ($request->has('min_salary')) {
            $query->where(function ($q) use ($minSalary) {
                $q->orWhere('min_salary', '>=', $minSalary);
                $q->orWhereNull('min_salary');
            });
        }

        if ($request->has('max_salary')) {
            $query->where(function ($q) use ($maxSalary) {
                $q->orWhere('max_salary', '<=', $maxSalary);
                $q->orWhereNull('max_salary');
            });
        }

        if (!empty($remotable)) {
            $query->where('remotable', $remotable);
        }

        $posts = $query->paginate();

        $filtersPostRemotable = PostRemotableEnum::getArrLowerKey();

        return view('applicant.index', [
            'posts'                => $posts,
            'arrCity'              => $arrCity,
            'searchCities'         => $searchCities,
            'filtersPostRemotable' => $filtersPostRemotable,
            'remotable'            => $remotable,
            'is_part_time'         => $is_part_time,
            'configs'              => $configs,
            'minSalary'            => $minSalary,
            'maxSalary'            => $maxSalary,
        ]);
    }

    public function show($postId)
    {
        $post = Post::query()
            ->with([
                'file',
                'company',
            ])
            ->approved()
            ->findOrFail($postId);
        return view('applicant.show', [
            'post' => $post,
        ]);
    }
}
