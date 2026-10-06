<?php

namespace App\View\Composers;

use App\Enums\MediaCollection;
use App\Models\Setting;
use App\Services\LocalFileUploader;
use App\Settings\SiteSettings;
use Illuminate\View\View;

class SiteSettingsComposer
{
    public function __construct(
        private readonly LocalFileUploader $fileUploader,
    ) {
    }

    public function compose(View $view): void
    {
        $values = Setting::query()
            ->pluck('value', 'key')
            ->toArray();

        $settings = collect(SiteSettings::definitions())
            ->mapWithKeys(function (array $definition) use ($values) {
                return [
                    $definition['name'] => $values[$definition['name']] ?? null,
                ];
            })
            ->all();

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

        return $this->fileUploader->getImageUrl((int) $mediaId,MediaCollection::LOGO);
    }
}

