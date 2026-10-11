<?php

namespace App\View\Composers;

use App\Enums\MediaCollection;
use App\Models\Setting;
use App\Queries\SettingQuery;
use App\Services\LocalFileUploader;
use App\Settings\SiteSettings;
use Illuminate\View\View;

class SiteSettingsComposer
{
    public function __construct(
        private readonly LocalFileUploader $fileUploader,
        private readonly SettingQuery $settingQuery,
    ) {
    }

    public function compose(View $view): void
    {
        $settings = $this->settingQuery->all();

        $settings['site_logo'] = $this->getImageUrl(
            $values['site_logo'] ?? null
        );

        $view->with('siteSettings', $settings);
    }

    private function getImageUrl(?string $mediaId): ?string
    {
        if (!$mediaId) {
            return null;
        }

        return $this->fileUploader->getImageUrl((int) $mediaId);
    }
}

