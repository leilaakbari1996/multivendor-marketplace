<?php

namespace App\Actions\Admin\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class UpdateFaqAction
{
    public function execute(Faq $faq, array $data): Faq
    {
        return DB::transaction(function () use ($faq, $data) {
            $hasCategories = array_key_exists('categories', $data);
            $categories = $data['categories'] ?? [];

            unset($data['categories']);

            if (array_key_exists('is_active', $data)) {
                $data['is_active'] = (bool) $data['is_active'];
            }

            $faq->update($data);

            // فقط وقتی دسته‌ها در درخواست آمده‌اند همگام‌سازی شود
            if ($hasCategories) {
                $faq->categories()->sync($categories);
            }

            return $faq->refresh();
        });
    }
}
