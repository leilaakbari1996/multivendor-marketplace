<?php

namespace App\Http\Requests\Admin\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'user_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'mobile' => [
                'required',
                'string',
                'size:11',
                Rule::unique('users', 'mobile')->ignore($this->user),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'type' => [
                'required',
                Rule::enum(UserType::class),
            ],

            'status' => [
                'required',
                Rule::enum(UserStatus::class),
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'integer',
                'exists:roles,id',
            ],

            'image' => [
                'nullable',
            ],
        ];

        if ($this->hasFile('image')) {
            $rules['image'][] = 'image';
            $rules['image'][] = 'mimes:jpg,jpeg,png,webp';
            $rules['image'][] = 'max:3072';
        } else {
            $rules['image'][] = 'nullable';
            $rules['image'][] = 'string';
        }

        return $rules;
    }
}
