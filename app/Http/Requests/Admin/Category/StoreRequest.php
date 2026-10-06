<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $tags = $this->input('tags');
        if (is_string($tags)) {
            $tags = json_decode($tags, true) ?: [];
        }
        $this->merge([ 'tags' => collect($tags) ->pluck('value') ->filter() ->values() ->all(), 'sort_order' => $this->integer('sort_order'), 'is_active' => $this->boolean('is_active'), 'parent_id' => $this->input('category'), ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:160',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'string',
                'max:100',
            ],
        ];
    }
}
