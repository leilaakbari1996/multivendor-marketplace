<?php

namespace Database\Seeders;

use App\Enums\MenuLocation;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHeaderMenus();
        $this->seedFooterMenus();
    }

    private function seedHeaderMenus(): void
    {
        $menus = [
            [
                'title' => 'خانه',
                'slug' => 'home',
                'url' => '/',
                'sort_order' => 1,
            ],
            [
                'title' => 'فروشگاه',
                'slug' => 'shop',
                'url' => '/products',
                'sort_order' => 2,
            ],
            [
                'title' => 'وبلاگ',
                'slug' => 'blog',
                'url' => 'blogs',
                'sort_order' => 4,
            ],
            [
                'title' => 'تماس با ما',
                'slug' => 'contact-us',
                'url' => 'contact',
                'sort_order' => 5,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                [
                    'slug' => $menu['slug'],
                    'location' => MenuLocation::HEADER->value,
                ],
                [
                    'title' => $menu['title'],
                    'url' => $menu['url'],
                    'parent_id' => null,
                    'sort_order' => $menu['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedFooterMenus(): void
    {
        $about = $this->createMenu(
            title: 'مارکت هاب',
            slug: 'footer-about',
            sortOrder: 1,
        );

        $this->createMenuItem(
            parent: $about,
            title: 'درباره ما',
            slug: 'about-us',
            url: 'about',
            sortOrder: 1,
        );

        $this->createMenuItem(
            parent: $about,
            title: 'قوانین و شرایط',
            slug: 'terms-and-conditions',
            url: '#',
            sortOrder: 2,
        );

        $this->createMenuItem(
            parent: $about,
            title: 'تماس با ما',
            slug: 'contact-us',
            url: 'contact',
            sortOrder: 3,
        );

        $this->createMenuItem(
            parent: $about,
            title: 'فرصت‌های شغلی',
            slug: 'careers',
            url: '#',
            sortOrder: 4,
        );

        $customerService = $this->createMenu(
            title: 'خدمات مشتریان',
            slug: 'footer-customer-service',
            sortOrder: 2,
        );

        $this->createMenuItem(
            parent: $customerService,
            title: 'سؤالات متداول',
            slug: 'faq',
            url: '#',
            sortOrder: 1,
        );

        $this->createMenuItem(
            parent: $customerService,
            title: 'حریم خصوصی',
            slug: 'privacy',
            url: '#',
            sortOrder: 2,
        );

        $this->createMenuItem(
            parent: $customerService,
            title: 'مرجوعی و بازپرداخت',
            slug: 'returns-and-refunds',
            url: '#',
            sortOrder: 3,
        );

        $this->createMenuItem(
            parent: $customerService,
            title: 'اطلاعات ارسال',
            slug: 'shipping-information',
            url: '#',
            sortOrder: 4,
        );
    }

    private function createMenu(
        string $title,
        string $slug,
        int $sortOrder,
    ): Menu {
        return Menu::updateOrCreate(
            [
                'slug' => $slug,
                'location' => MenuLocation::FOOTER->value,
            ],
            [
                'title' => $title,
                'url' => null,
                'parent_id' => null,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]
        );
    }

    private function createMenuItem(
        Menu $parent,
        string $title,
        string $slug,
        string $url,
        int $sortOrder,
    ): Menu {
        return Menu::updateOrCreate(
            [
                'slug' => $slug,
                'location' => MenuLocation::FOOTER->value,
            ],
            [
                'title' => $title,
                'url' => $url,
                'parent_id' => $parent->id,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]
        );
    }
}

