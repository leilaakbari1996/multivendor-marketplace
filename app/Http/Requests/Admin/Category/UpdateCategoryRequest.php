<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

use App\Models\Category;
use Closure;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends BaseCategoryRequest
{
    /**
     * The type cannot change once products or FAQs are attached,
     * because they only make sense inside their own type.
     */
    protected function typeRules(): array
    {
        $category = $this->category();

        return [
            ...parent::typeRules(),
            function (string $attribute, mixed $value, Closure $fail) use ($category): void {
                $changed = $value !== $category->type->value;

                if ($changed && ($category->products()->exists() || $category->faqs()->exists())) {
                    $fail(__('category.validation.type_locked'));
                }
            },
        ];
    }

    /**
     * A category cannot be its own parent, and a category that already has
     * children must stay top-level (the tree has two levels).
     */
    protected function parentRules(): array
    {
        $category = $this->category();

        return [
            ...parent::parentRules(),
            Rule::notIn([$category->getKey()]),
            function (string $attribute, mixed $value, Closure $fail) use ($category): void {
                if ($category->children()->exists()) {
                    $fail(__('category.validation.has_children'));
                }
            },
        ];
    }

    private function category(): Category
    {
        /** @var Category $category */
        $category = $this->route('category');

        return $category;
    }
}
