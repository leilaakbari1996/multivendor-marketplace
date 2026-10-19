<?php

declare(strict_types=1);

namespace App\Actions\Admin\Faq;

use App\Models\Faq;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class StoreFaqAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): Faq
    {
        $categories = Arr::pull($data, 'categories', []);

        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['sort_order'] ??= ((int) Faq::query()->max('sort_order')) + 1;

        return DB::transaction(function () use ($data, $categories): Faq {
            $faq = Faq::create($data);

            $faq->categories()->sync($categories);

            return $faq;
        });
    }
}
