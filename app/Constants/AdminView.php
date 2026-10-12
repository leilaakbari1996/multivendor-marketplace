<?php

namespace App\Constants;

/**
 * مسیر ویوها و عنوان صفحات پنل ادمین، یک‌جا و متمرکز.
 * هر کنترلر به‌جای هاردکد کردن رشته، از اینجا استفاده می‌کنه.
 */
final class AdminView
{
    public const PERFIX = 'admin.pages.';

    public const PERFIX_ROUTE = 'panel.';
    // Dashboard
    public const DASHBOARD_INDEX = self::PERFIX.'dashboard.index';
    public const DASHBOARD_TITLE = 'داشبورد';

    //Faqs
    public const FAQ_INDEX  = 'admin.pages.faqs.index';
    public const FAQ_CREATE = 'admin.pages.faqs.create';
    public const FAQ_EDIT   = 'admin.pages.faqs.edit';

    // Categories
    public const CATEGORY_INDEX = self::PERFIX.'categories.index';
    public const CATEGORY_CREATE = self::PERFIX.'categories.create';
    public const CATEGORY_EDIT = self::PERFIX.'categories.edit';

    // Users
    public const USER_INDEX = self::PERFIX . 'users.index';
    public const USER_CREATE = self::PERFIX . 'users.create';
    public const USER_EDIT = self::PERFIX . 'users.edit';

    // Vendors
    public const VENDOR_INDEX = self::PERFIX . 'vendors.index';
    public const VENDOR_CREATE = self::PERFIX . 'vendors.create';
    public const VENDOR_EDIT = self::PERFIX . 'vendors.edit';

    // Products
    public const PRODUCT_INDEX = self::PERFIX . 'products.index';
    public const PRODUCT_CREATE = self::PERFIX . 'products.create';
    public const PRODUCT_EDIT = self::PERFIX . 'products.edit';

    // Roles
    public const ROLE_INDEX = self::PERFIX . 'roles.index';
    public const ROLE_CREATE = self::PERFIX . 'roles.create';
    public const ROLE_EDIT = self::PERFIX . 'roles.edit';

    // Permissions
    public const PERMISSION_INDEX = self::PERFIX . 'permissions.index';
    public const PERMISSION_CREATE = self::PERFIX . 'permissions.create';
    public const PERMISSION_EDIT = self::PERFIX . 'permissions.edit';

    // Carts
    public const CART_INDEX = self::PERFIX . 'carts.index';
    public const CART_SHOW = self::PERFIX . 'carts.show';

    // Orders
    public const ORDER_INDEX = self::PERFIX . 'orders.index';
    public const ORDER_SHOW = self::PERFIX . 'orders.show';

    // COUPON
    public const COUPON_INDEX = self::PERFIX . 'coupons.index';
    public const COUPON_CREATE = self::PERFIX . 'coupons.create';
    public const COUPON_EDIT = self::PERFIX . 'coupons.edit';

    // Contact
    public const CONTACT_INDEX = self::PERFIX . 'contacts.index';
    public const CONTACT_EDIT = self::PERFIX . 'contacts.edit';

    // media
    public const MEDIA_INDEX = self::PERFIX .'media.index';

    // menu
    public const MENU_INDEX = self::PERFIX .'menus.index';
    public const MENU_CREATE = self::PERFIX .'menus.create';
    public const MENU_EDIT = self::PERFIX .'menus.edit';

    // SETTING
    public const SETTING_INDEX = self::PERFIX .'settings.index';

    // BANNER
    public const BANNER_INDEX = self::PERFIX .'banners.index';
    public const BANNER_CREATE = self::PERFIX .'banners.create';
    public const BANNER_EDIT = self::PERFIX .'banners.edit';

    //post
    public const POST_INDEX = 'admin.pages.posts.index';
    public const POST_CREATE = 'admin.pages.posts.create';
    public const POST_EDIT = 'admin.pages.posts.edit';
}
