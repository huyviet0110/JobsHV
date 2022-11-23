<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;

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
        $data = $this->model->paginate();

        foreach ($data as $each) {
            $each->currency_salary = $each->currency_salary_code;
            $each->status          = $each->status_name;
        }

//        return $this->errorResponse('Import Error Test');

        $arr['data'] = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();
        return $this->successResponse($arr);
    }
}
