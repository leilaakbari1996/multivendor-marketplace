<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostStatus;
use App\Support\DateHelper;
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
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                Rule::enum(PostStatus::class),
            ],

            'is_featured' => [
                'sometimes',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $publishedAt = $this->input('published_at');
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'published_at' => DateHelper::toGregorian($publishedAt)
        ]);
    }
}

