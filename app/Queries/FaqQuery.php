<?php

namespace App\Queries;

use App\Enums\CategoryType;
use App\Models\Faq;

class FaqQuery
{
    public function __construct(
        private readonly CategoryQuery $categoryQuery,
        private readonly SettingQuery $settingQuery,
    ) {
    }

    public function categories()
    {
        return $this->categoryQuery->get(CategoryType::Faq);
    }

    public function faqs()
    {
        $query = Faq::query()
            ->active()
            ->ordered();

        return $query->get();
    }


    public function get(): array
    {
        return [
            'settings' => $this->settingQuery->only([
                'faq_hero_title',
                'faq_hero_description',
            ]),
            'categories'         => $this->categories(),
            'faqs'               => $this->faqs()

        ];
    }
}
