<?php

namespace App\Http\Requests\Post;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'company' => [
                'string',
                'nullable',
            ],
            'languages' => [
                'required',
                'nullable',
                'filled',
            ],
            'city' => [
                'required',
                'string',
                'filled',
            ],
            'district' => [
                'nullable',
                'string',
            ],
            'currency_salary' => [
                'required',
                Rule::in(PostCurrencySalaryEnum::getValues()),
            ],
            'requirement' => [
                'nullable',
                'string',
            ],
            'number_applicants' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'remotables' => [
                'required',
                'array',
            ],
            'is_part_time' => [
                'nullable',
                'accepted',
            ],
            'job_title' => [
                'required',
                'nullable',
                'string',
                'filled',
                'min:3',
                'max:255',
            ],
            'slug' => [
                'required',
                'nullable',
                'string',
                'filled',
                'min:3',
                'max:255',
                Rule::unique(Post::class),
            ],
            'start_date' => [
                'nullable',
                'string',
                'before:end_date',
            ],
            'end_date' => [
                'nullable',
                'string',
                'after:start_date',
            ],
        ];

        $rules['min_salary'] = [
            'nullable',
            'numeric',
        ];

        $rules['max_salary'] = [
            'nullable',
            'numeric',
        ];

        if(!empty($this->min_salary) && !empty($this->max_salary)){
            $rules['min_salary'][] = 'lt:max_salary';
            $rules['max_salary'][] = 'gt:min_salary';
        }

        return $rules;
    }
}
