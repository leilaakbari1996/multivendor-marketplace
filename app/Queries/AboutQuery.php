<?php

namespace App\Queries;

class AboutQuery
{
    public function __construct(
        private readonly ShopBenefitQuery $shopBenefitQuery,
        private readonly ProductQuery $productQuery,
        private readonly UserQuery $userQuery,
        private readonly VendorQuery $vendorQuery,
        private readonly SettingQuery $settingQuery,
    ) {
    }

    public function shopBenefits()
    {
        return $this->shopBenefitQuery->get();
    }

    public function productsCount(): int
    {
        return $this->productQuery->publishedCount();
    }

    public function get(): array
    {
        return [
            'settings' => $this->settingQuery->only([
                'about_hero_title',
                'about_hero_description',
                'about_our_story',
                'cta_shop_title',
                'cta_shop_description'
            ]),
            'shopBenefits'         => $this->shopBenefits(),
            'stats'        => [
                'products'  => $this->productQuery->publishedCount(),
                'customers' => $this->userQuery->customersCount(),
                'vendors'   => $this->vendorQuery->approvedCount(),
            ],
        ];
    }
}
