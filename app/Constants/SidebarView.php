<?php

namespace App\Constants;

/**
 * مسیر ویوها و عنوان صفحات پنل ادمین، یک‌جا و متمرکز.
 * هر کنترلر به‌جای هاردکد کردن رشته، از اینجا استفاده می‌کنه.
 */
final class SidebarView
{
    public const PERFIX = 'admin.pages.';
    // Dashboard
    public const DASHBOARD_INDEX = self::PERFIX.'dashboard.index';
    public const DASHBOARD_TITLE = 'داشبورد';

    // Categories
    public const CATEGORY_INDEX = self::PERFIX.'categories.index';
    public const CATEGORY_CREATE = self::PERFIX.'categories.create';
    public const CATEGORY_EDIT = 'admin.pages.categories.edit';
    public const CATEGORY_TITLE = 'دسته‌بندی‌ها';

    // Brands
    public const BRAND_INDEX = 'admin.pages.brands.index';
    public const BRAND_CREATE = 'admin.pages.brands.create';
    public const BRAND_EDIT = 'admin.pages.brands.edit';
    public const BRAND_TITLE = 'برندها';

    // Vendors
    public const VENDOR_INDEX = 'admin.pages.vendors.index';
    public const VENDOR_SHOW = 'admin.pages.vendors.show';
    public const VENDOR_TITLE = 'فروشنده‌ها';

    // Products
    public const PRODUCT_INDEX = 'admin.pages.products.index';
    public const PRODUCT_SHOW = 'admin.pages.products.show';
    public const PRODUCT_TITLE = 'محصولات';

    // Comments
    public const COMMENT_INDEX = 'admin.pages.comments.index';
    public const COMMENT_TITLE = 'نظرات';

    // Coupons
    public const COUPON_INDEX = 'admin.pages.coupons.index';
    public const COUPON_CREATE = 'admin.pages.coupons.create';
    public const COUPON_EDIT = 'admin.pages.coupons.edit';
    public const COUPON_TITLE = 'کوپن‌های تخفیف';

    // Orders
    public const ORDER_INDEX = 'admin.pages.orders.index';
    public const ORDER_SHOW = 'admin.pages.orders.show';
    public const ORDER_TITLE = 'سفارشات';

    // Blog
    public const BLOG_CATEGORY_INDEX = 'admin.pages.blog.categories.index';
    public const BLOG_POST_INDEX = 'admin.pages.blog.posts.index';
    public const BLOG_POST_CREATE = 'admin.pages.blog.posts.create';
    public const BLOG_POST_EDIT = 'admin.pages.blog.posts.edit';
    public const BLOG_TITLE = 'بلاگ';

}
