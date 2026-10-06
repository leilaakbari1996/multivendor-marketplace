<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Vendor\DeleteVendorAction;
use App\Actions\Admin\Vendor\StoreVendorAction;
use App\Constants\AdminView;
use App\Enums\MediaCollection;
use App\Enums\UserType;
use App\Enums\VendorStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vendor\StoreRequest;
use App\Http\Requests\Admin\Vendor\UpdateRequest;
use App\Models\User;
use App\Models\Vendor;
use App\Services\LocalFileUploader;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;
use App\Actions\Admin\Vendor\UpdateVendorAction;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreVendorAction $storeVendorAction,
        private readonly LocalFileUploader $fileUploader,
        private readonly UpdateVendorAction $updateVendorAction,
        private readonly DeleteVendorAction $deleteVendorAction,
    ) {
    }

    public function index()
    {
        $title = 'فروشندگان';

        return view(
            AdminView::VENDOR_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Vendor::query()
                ->select([
                    'id',
                    'user_id',
                    'store_name',
                    'commission_rate',
                    'status',
                    'national_code',
                ])
                ->with('user:id,user_name,mobile'),

            actionsView: 'admin.pages.vendors.partials._actions',

            extraColumns: [
                'user.user_name' => fn ($row) => $row->user?->user_name
                    ?? $row->user?->mobile
                    ?? '-',

                'commission_rate' => fn ($row) => $row->commission_rate . '%',

                'status' => fn ($row) => BadgeHelper::button($row->status),
            ],
        );
    }

    public function create()
    {
        $title = 'ایجاد فروشنده';

        $users = User::query()
            ->where('type', UserType::VENDOR)
//            ->whereDoesntHave('vendor')
            ->get([
                'id',
                'user_name',
                'mobile',
            ]);

        return view(
            AdminView::VENDOR_CREATE,
            compact(
                'title',
                'users',
            ) + [
                'statuses' => VendorStatus::options(),
            ]
        );
    }

    public function store(StoreRequest $request)
    {
        $this->storeVendorAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE.'vendor.index')
            ->with('success', 'فروشنده با موفقیت ایجاد شد.');
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load([
            'user:id,user_name,mobile',
            'media',
        ]);

        $users = User::query()
            ->where('type', UserType::VENDOR)
            ->where(function ($query) use ($vendor) {
                $query
                    ->whereDoesntHave('vendor')
                    ->orWhere('id', $vendor->user_id);
            })
            ->get([
                'id',
                'user_name',
                'mobile',
            ]);

        $statuses = VendorStatus::options();

        $logo = $vendor->media
            ->where('collection', MediaCollection::LOGO)
            ->first();

        $banner = $vendor->media
            ->where('collection', MediaCollection::BANNER)
            ->first();

        $logoUrl = $logo
            ? $this->fileUploader->url(
                path: $logo->file_path,
                disk: $logo->disk,
            )
            : null;

        $bannerUrl = $banner
            ? $this->fileUploader->url(
                path: $banner->file_path,
                disk: $banner->disk,
            )
            : null;

        $title = 'ویرایش فروشنده';

        return view(
            AdminView::VENDOR_EDIT,
            compact(
                'title',
                'vendor',
                'users',
                'statuses',
                'logoUrl',
                'bannerUrl',
            )
        );
    }

    public function update(
        UpdateRequest $request,
        Vendor $vendor,
    ) {
        Log::info('UpdateVendorAction started', [
            'request' => $request->all(),
        ]);
        $this->updateVendorAction->execute(
            vendor: $vendor,
            data: $request->validated(),
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE.'vendor.index')
            ->with('success', 'فروشنده با موفقیت ویرایش شد.');
    }

    public function destroy(Vendor $vendor)
    {
        $this->deleteVendorAction->execute($vendor);

        return response()->json([
            'message' => 'فروشنده با موفقیت حذف شد.',
        ]);
    }
}
