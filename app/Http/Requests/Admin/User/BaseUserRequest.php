<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

abstract class BaseUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'mobile' => [
                'required',
                'string',
                'size:11',
                $this->mobileUniqueRule(),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'type' => $this->typeRules(),
            'status' => $this->statusRules(),
            'roles' => [
                'nullable',
                'array',
            ],
            'roles.*' => [
                'integer',
                'distinct',
                Rule::exists('roles', 'id'),
            ],
            'image' => $this->imageRules(),
        ];
    }

    abstract protected function mobileUniqueRule(): Unique;

    abstract protected function typeRules(): array;

    abstract protected function statusRules(): array;

    abstract protected function imageRules(): array;
}
