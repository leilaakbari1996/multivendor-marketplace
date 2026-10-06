<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Banner\DeleteBannerAction;
use App\Actions\Admin\Banner\StoreBannerAction;
use App\Actions\Admin\Banner\UpdateBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\StoreRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
use App\Models\Banner;
use App\Constants\AdminView;
use App\Traits\HasDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BannerController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreBannerAction $storeBannerAction,
        private readonly UpdateBannerAction $updateBannerAction,
        private readonly DeleteBannerAction $deleteBannerAction,
    ) {}

    public function index(): View
    {
        $title = 'بنرها';

        return view(
            AdminView::BANNER_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Banner::query()
                ->select([
                    'id',
                    'title',
                    'subtitle',
                    'position',
                    'sort_order',
                    'is_active',
                ]),
            actionsView: 'admin.pages.banners.partials._actions',
            extraColumns: [
                'position' => fn ($row) => $row->position->label(),
                'is_active' => fn ($row) => \App\Support\BadgeHelper::booleanButton(
                    value: (bool) $row->is_active,
                    trueLabel: 'فعال',
                    falseLabel: 'غیرفعال',
                ),
            ],
        );
    }

    public function create(): View
    {
        $title = 'ایجاد بنر';

        return view(
            AdminView::BANNER_CREATE,
            compact('title')
        );
    }

    public function store(
        StoreRequest $request
    ): RedirectResponse {
        $this->storeBannerAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'banner.index')
            ->with('success', 'بنر با موفقیت ایجاد شد.');
    }

    public function edit(Banner $banner): View
    {
        $title = 'ویرایش بنر';

        return view(
            AdminView::BANNER_EDIT,
            compact('title', 'banner')
        );
    }

    public function update(
        UpdateRequest $request,
        Banner $banner
    ): RedirectResponse {
        $this->updateBannerAction->execute(
            banner: $banner,
            data: $request->validated()
        );

        return redirect()
            ->route(\App\Constants\AdminView::PERFIX_ROUTE . 'banner.index')
            ->with('success', 'بنر با موفقیت بروزرسانی شد.');
    }

    public function destroy(Banner $banner)
    {
        $this->deleteBannerAction->execute($banner);

        return response()->json([
            'message' => 'بنر با موفقیت حذف شد.',
        ]);
    }
}
