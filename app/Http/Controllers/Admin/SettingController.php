<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Setting\UpdateSettingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateRequest;
use App\Constants\AdminView;
use App\Models\Media;
use App\Models\Setting;
use App\Services\LocalFileUploader;
use App\Settings\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private readonly UpdateSettingAction $updateSettingAction,
        private readonly LocalFileUploader $fileUploader,
    ) {
    }

    public function index(): View
    {
        $title = 'تنظیمات سایت';

        $definitions = SiteSettings::definitions();

        $values = Setting::query()
            ->pluck('value', 'key')
            ->toArray();

        $settings = collect(SiteSettings::definitions())
            ->map(function (array $definition) use ($values) {

                $value = $values[$definition['name']] ?? null;

                if ($definition['type'] === 'image' && $value) {

                    $media = Media::query()
                        ->find($value);

                    $value = $media
                        ? $this->fileUploader->url(
                            path: $media->file_path,
                            disk: $media->disk,
                        )
                        : null;
                }

                return [
                    ...$definition,
                    'value' => $value,
                ];
            })
            ->all();

        return view(
            AdminView::SETTING_INDEX,
            compact(
                'title',
                'definitions',
                'settings',
            )
        );
    }

    public function update(
        UpdateRequest $request,
    ): RedirectResponse {
        $this->updateSettingAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'setting.index')
            ->with('success', 'تنظیمات با موفقیت بروزرسانی شد.');
    }
}
