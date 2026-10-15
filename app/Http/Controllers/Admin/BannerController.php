<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Banner\DeleteBannerAction;
use App\Actions\Admin\Banner\StoreBannerAction;
use App\Actions\Admin\Banner\UpdateBannerAction;
use App\Constants\AdminView;
use App\Datatables\Admin\BannerDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\StoreRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
use App\Models\Banner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BannerController extends Controller
{
    public function __construct(
        private readonly StoreBannerAction $storeBannerAction,
        private readonly UpdateBannerAction $updateBannerAction,
        private readonly DeleteBannerAction $deleteBannerAction,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Banner::class);

        return view(AdminView::BANNER_INDEX, [
            'title' => __('banner.title'),
        ]);
    }

    public function data(BannerDatatable $datatable): JsonResponse
    {
        $this->authorize('viewAny', Banner::class);

        return $datatable->toJson();
    }

    public function create(): View
    {
        $this->authorize('create', Banner::class);

        return view(AdminView::BANNER_CREATE, [
            'title' => __('banner.create'),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Banner::class);

        $this->storeBannerAction->execute($request->validated());

        return to_route('admin.banner.index')
            ->with('success', __('banner.created'));
    }

    public function edit(Banner $banner): View
    {
        $this->authorize('update', $banner);

        return view(AdminView::BANNER_EDIT, [
            'title' => __('banner.edit'),
            'banner' => $banner,
        ]);
    }

    public function update(UpdateRequest $request, Banner $banner): RedirectResponse
    {
        $this->authorize('update', $banner);

        $this->updateBannerAction->execute(
            banner: $banner,
            data: $request->validated(),
        );

        return to_route('admin.banner.index')
            ->with('success', __('banner.updated'));
    }

    public function destroy(Banner $banner): JsonResponse
    {
        $this->authorize('delete', $banner);

        $this->deleteBannerAction->execute($banner);

        return response()->json([
            'message' => __('banner.deleted'),
        ]);
    }
}
