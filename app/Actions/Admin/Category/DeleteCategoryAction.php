<?php

declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Models\Category;

final class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        // Soft delete: the record and its media are kept, so restore() works.
        $category->delete();
    }
}
