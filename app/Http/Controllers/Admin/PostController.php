<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Utils\Paginator;

class PostController extends Controller
{
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
        return view("admin.$this->table.create");
    }

    public function importCsv(Request $request)
    {
        Excel::import(new PostImport, $request->file('file'));
    }
}
