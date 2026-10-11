<?php

namespace App\Queries;

use App\Enums\ContactSubject;
use App\Support\Collection\ContactBoxes;

class ContactQuery
{

    public function __construct(
//        private readonly ShopBenefitQuery $shopBenefitQuery,
//        private readonly ProductQuery $productQuery,
//        private readonly UserQuery $userQuery,
//        private readonly VendorQuery $vendorQuery,
        private readonly SettingQuery $settingQuery,
    ) {
    }

    private function subjects()
    {
        $subjects = ContactSubject::options();
        return $subjects;
    }

    public function contactBoxes($settings)
    {
        $contactBoxes = ContactBoxes::make($settings);
        return $contactBoxes;
    }

    public function settings()
    {
        $settings = $this->settingQuery->only([
            'contact_hero_title',
            'contact_hero_description',
            'contact_email',
            'contact_address',
            'social_instagram',
            'social_telegram',
            'social_youtube',
            'social_facebook',
            'contact_hours',
            'social_whatsapp',
            'support_phone'
        ]);
        return $settings;
    }

    public function get(): array
    {
        $settings = $this->settings();
        return [
            'settings'     => $settings,
            'contactBoxes' => $this->contactBoxes($settings),
            'subjects'     => $this->subjects()
        ];
    }

}
