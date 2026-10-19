<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Faq;

use App\Enums\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'icon' => filled($this->input('icon'))
                ? trim($this->input('icon'))
                : 'bi-question-circle',
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'icon' => [
                'required',
                'string',
                'max:50',
                'regex:/^bi-[a-z0-9-]+$/',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:65535',
            ],
            'is_active' => ['required', 'boolean'],

            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => [
                'bail',
                'required',
                'integer',
                'distinct',
                Rule::exists('categories', 'id')
                    ->where('type', CategoryType::Faq->value)
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
