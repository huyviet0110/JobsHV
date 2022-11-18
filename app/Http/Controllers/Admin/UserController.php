<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public object $model;
    public string $table;

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
    }

    public function index()
    {
        $data = $this->model->paginate(7);

        return view("admin.$this->table.index", [
            'data' => $data,
        ]);
    }
}
