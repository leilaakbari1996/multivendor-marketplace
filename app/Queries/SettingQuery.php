<?php

namespace App\Queries;

use App\Models\Setting;
use App\Settings\SiteSettings;
use Illuminate\Support\Facades\Cache;

final class SettingQuery
{
    private const CACHE_KEY = 'site_settings_all';

    /**
     * همه تنظیمات مرج‌شده با definitions
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $values = $this->rawValues();

            return collect(SiteSettings::definitions())
                ->mapWithKeys(fn (array $def) => [
                    $def['name'] => $values[$def['name']] ?? $def['default'] ?? null,
                ])
                ->all();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    /**
     * @param string[] $keys
     * @return array<string, mixed>
     */
    public function only(array $keys): array
    {
        return collect($this->all())
            ->only($keys)
            ->all();
    }

    /**
     * فقط خواندن خام از دیتابیس — تک‌مسئولیت
     * @return array<string, ?string>
     */
    private function rawValues(): array
    {
        return Setting::query()
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
