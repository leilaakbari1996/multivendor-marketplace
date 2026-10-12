<?php

namespace App\Http\Requests\Admin\Faq;

use App\Enums\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'icon' => ['required', 'string', 'max:50', 'regex:/^bi-[a-z0-9-]+$/'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],

            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => [
                'integer',
                'distinct',
                Rule::exists('categories', 'id')
                    ->where('type', CategoryType::Faq->value)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

//    public function attributes(): array
//    {
//        return [
//            'question' => 'سوال',
//            'answer' => 'پاسخ',
//            'icon' => 'آیکن',
//            'sort_order' => 'ترتیب نمایش',
//            'is_active' => 'وضعیت',
//            'categories' => 'دسته‌بندی',
//            'categories.*' => 'دسته‌بندی',
//        ];
//    }
//
//    public function messages(): array
//    {
//        return [
//            'icon.regex' => 'آیکن باید نام یک کلاس Bootstrap Icons باشد، مثلاً bi-truck.',
//            'categories.required' => 'حداقل یک دسته‌بندی انتخاب کنید.',
//            'categories.min' => 'حداقل یک دسته‌بندی انتخاب کنید.',
//            'categories.*.exists' => 'دسته‌بندی انتخاب‌شده معتبر نیست.',
//        ];
//    }
}
