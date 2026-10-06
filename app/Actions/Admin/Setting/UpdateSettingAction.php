<?php

namespace App\Actions\Admin\Setting;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\Setting;
use App\Settings\SiteSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateSettingAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(array $data): void
    {
        DB::transaction(function () use ($data) {

            foreach (SiteSettings::definitions() as $definition) {

                $key = $definition['name'];

                if (!array_key_exists($key, $data)) {
                    continue;
                }

                $value = $data[$key];

                $setting = Setting::query()
                    ->where('key', $key)
                    ->firstOrCreate([
                        'key' => $key,
                    ]);

                if (
                    $definition['type'] === 'image'
                    && $value instanceof UploadedFile
                ) {
                    $this->updateImage(
                        setting: $setting,
                        file: $value,
                    );

                    continue;
                }

                $setting->update([
                    'value' => $value,
                ]);
            }
        });
    }

    private function updateImage(
        Setting $setting,
        UploadedFile $file,
    ): void {
        $setting->media?->delete();

        $media = $this->storeMediaAction->execute(
            model: $setting,
            file: $file,
            collection: MediaCollection::IMAGE,
            directory: 'settings',
        );

        $setting->update([
            'value' => $media->id,
        ]);
    }
}
