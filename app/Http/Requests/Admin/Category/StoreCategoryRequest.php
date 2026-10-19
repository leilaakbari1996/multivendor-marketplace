<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

/**
 * Creating a category needs no rules beyond the shared ones.
 * It exists as its own class so the controller stays explicit and
 * create-only rules have an obvious home.
 */
class StoreCategoryRequest extends BaseCategoryRequest {}
