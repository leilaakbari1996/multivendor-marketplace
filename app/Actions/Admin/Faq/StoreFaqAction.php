<?php

namespace App\Actions\Admin\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class StoreFaqAction
{
    public function execute(array $data): Faq
    {
        return DB::transaction(function () use ($data) {
            $categories = $data['categories'] ?? [];

            unset($data['categories']);

            $data['is_active'] = (bool) ($data['is_active'] ?? true);
            $data['sort_order'] ??= ((int) Faq::query()->max('sort_order')) + 1;

            $faq = Faq::create($data);

            // رابطه‌ی مورف: ثبت در جدول categorizables
            $faq->categories()->sync($categories);

            return $faq;
        });
    }
}
