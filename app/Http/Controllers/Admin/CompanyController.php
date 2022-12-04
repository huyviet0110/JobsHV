<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Company\StoreRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CompanyController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Company::query();
        $this->table = Company::class;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $arr = $request->validated();
            $arr['logo'] = optional($request->file('logo'))->store('company_logo');
            Company::create($arr);

            return $this->successResponse();
        } catch (Throwable $e) {
            $message = '';
            if($e->getCode() === '23000'){
                $message = "The company's name already exists!";
            }

            return $this->errorResponse($message);
        }

    }
}
