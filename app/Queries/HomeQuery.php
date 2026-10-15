<?php

namespace App\Queries;


use App\Enums\CategoryType;

class HomeQuery
{

    public function __construct(
        private readonly BannerQuery $bannerQuery,
        private readonly ProductQuery $productQuery,
        private readonly CategoryQuery $categoryQuery,
        private readonly PostQuery $postQuery,
        private readonly ShopBenefitQuery $shopBenefitQuery,
    ) {
    }

    public function bestSellingProducts()
    {
        return $this->productQuery->bestSelling();
    }

    public function featuredProducts()
    {
      return $this->productQuery->featured();
    }

    public function categories()
    {
        return $this->categoryQuery->get(CategoryType::Product);
    }


    public function banners(): array
    {
        return $this->bannerQuery->forHome();
    }

    public function latestPosts()
    {
        $filter['featured'] = true;
        return $this->postQuery->limit(3,$filter);
    }
    public function shopBenefits()
    {
        return $this->shopBenefitQuery->get();
    }

    public function get(): array
    {
        return [
            'banners'              => $this->banners(),
            'categories'           => $this->categories(),
            'featuredProducts'     => $this->featuredProducts(),
            'bestSellingProducts'  => $this->bestSellingProducts(),
            'latestPosts'          => $this->latestPosts(),
            'shopBenefits'         => $this->shopBenefits(),
        ];
    }
}
