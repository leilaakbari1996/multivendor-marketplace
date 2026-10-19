<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

use App\Enums\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

/**
 * Rules shared by the store and update requests.
 * Children override typeRules() / parentRules() when they need extra checks.
 */
abstract class BaseCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is handled by CategoryPolicy in the controller.
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tags' => $this->normalizedTags(),
            // Keep garbage like "abc" visible to the "integer" rule instead of hiding it as 0.
            'sort_order' => $this->input('sort_order') ?? 0,
            // An unchecked switch sends nothing, so make both values explicit.
            'is_active' => $this->boolean('is_active'),
            'is_main' => $this->boolean('is_main'),
            // The form field is called "category", the column is parent_id.
            'parent_id' => $this->input('category'),
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'is_active' => ['required', 'boolean'],
            'is_main' => ['required', 'boolean'],

            'type' => $this->typeRules(),
            'parent_id' => $this->parentRules(),
            'image' => $this->imageRules(),

            'tags' => ['nullable', 'array', 'max:20'],
            'tags.*' => ['string', 'max:100'],
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected function typeRules(): array
    {
        return ['required', Rule::enum(CategoryType::class)];
    }

    /**
     * The parent must exist, not be deleted, be a top-level category
     * (the tree has two levels) and have the same type as this category.
     *
     * @return array<int, mixed>
     */
    protected function parentRules(): array
    {
        return [
            'nullable',
            'integer',
            Rule::exists('categories', 'id')
                ->whereNull('deleted_at')
                ->whereNull('parent_id')
                ->where('type', $this->input('type')),
        ];
    }

    /**
     * The image is optional when creating and when updating.
     * Change "nullable" to "required" in the store request if every category needs one.
     *
     * @return array<int, mixed>
     */
    protected function imageRules(): array
    {
        return [
            'bail',
            'nullable',
            File::image()
                ->types(['jpg', 'jpeg', 'png', 'webp'])
                ->max('3mb')
                // Guards against huge-pixel images that exhaust memory when decoded.
                ->dimensions(Rule::dimensions()->maxWidth(4000)->maxHeight(4000)),
        ];
    }

    /**
     * Tags arrive as a JSON string from the tag input: [{"value":"a"},{"value":"b"}].
     *
     * @return list<string>
     */
    private function normalizedTags(): array
    {
        $tags = $this->input('tags');

        if (is_string($tags)) {
            $tags = json_decode($tags, true);
        }

        if (! is_array($tags)) {
            return [];
        }

        return collect($tags)
            ->map(fn (mixed $tag): mixed => is_array($tag) ? ($tag['value'] ?? null) : $tag)
            ->filter(fn (mixed $tag): bool => is_string($tag) && $tag !== '')
            ->unique()
            ->values()
            ->all();
    }
}
