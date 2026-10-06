
@php
    use App\Constants\AdminView;
    use App\Support\DateHelper;

    $featuredFrom = $product->featured_from
        ? DateHelper::toJalali($product->featured_from)
        : null;

    $featuredUntil = $product->featured_until
        ? DateHelper::toJalali($product->featured_until)
        : null;
@endphp

@extends('admin.layouts.app')

@push('styles')
    @include('admin.assets.create_css')

    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/src/tomSelect/tom-select.default.min.css') }}"
    >

    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}"
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css"
    >
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'محصولات',
                'url' => route('panel.product.index'),
            ],
        ]"
        current="ویرایش محصول"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'product.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- Main Content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                {{-- Product Information --}}
                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">

                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="name"
                                id="product-name"
                                label="نام محصول"
                                placeholder="نام محصول"
                                :value="old('name', $product->name)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="slug"
                                id="product-slug"
                                label="Slug"
                                placeholder="product-slug"
                                :value="old('slug', $product->slug)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="sku"
                                id="product-sku"
                                label="SKU"
                                placeholder="کد محصول"
                                :value="old('sku', $product->sku)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="price"
                                type="number"
                                id="product-price"
                                label="قیمت"
                                placeholder="قیمت محصول"
                                min="0"
                                :value="old('price', $product->price)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="discount_price"
                                type="number"
                                id="product-discount-price"
                                label="قیمت با تخفیف"
                                placeholder="قیمت با تخفیف"
                                min="0"
                                :value="old('discount_price', $product->discount_price)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="stock"
                                type="number"
                                id="product-stock"
                                label="موجودی"
                                placeholder="تعداد موجودی"
                                min="0"
                                :value="old('stock', $product->stock)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="weight"
                                type="number"
                                id="product-weight"
                                label="وزن (گرم)"
                                placeholder="وزن محصول به گرم"
                                min="0"
                                :value="old('weight', $product->weight)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="description"
                                label="توضیحات"
                                placeholder="توضیحات محصول"
                                rows="6"
                                :value="old('description', $product->description)"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Vendor --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.tom-select
                            name="vendor_id"
                            label="فروشنده"
                            :options="$vendors->mapWithKeys(fn ($vendor) => [
                                $vendor->id => $vendor->store_name,
                            ])->toArray()"
                            :value="old('vendor_id', $product->vendor_id)"
                            placeholder="انتخاب فروشنده"
                        />

                    </div>

                    {{-- Category --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.tom-select
                            name="category_id"
                            label="دسته بندی"
                            :options="$categories->pluck('name', 'id')->toArray()"
                            :value="old('category_id', $product->category_id)"
                            placeholder="انتخاب دسته بندی"
                        />

                    </div>

                    {{-- Status --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.tom-select
                            name="status"
                            label="وضعیت"
                            :options="$statuses"
                            :value="old('status', $product->status->value)"
                            placeholder="انتخاب وضعیت"
                        />

                    </div>

                    {{-- Featured --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <div class="form-check form-switch">

                            <input
                                type="hidden"
                                name="is_featured"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_featured"
                                id="product-is-featured"
                                value="1"
                                @checked(old('is_featured', $product->is_featured))
                            >

                            <label
                                class="form-check-label"
                                for="product-is-featured"
                            >
                                محصول ویژه
                            </label>

                        </div>

                    </div>

                    {{-- Featured From --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.input
                            name="featured_from"
                            type="text"
                            id="product-featured-from"
                            label="شروع ویژه بودن"
                            :value="old('featured_from', $featuredFrom)"
                            jdp
                        />

                    </div>

                    {{-- Featured Until --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.input
                            name="featured_until"
                            type="text"
                            id="product-featured-until"
                            label="پایان ویژه بودن"
                            :value="old('featured_until', $featuredUntil)"
                            jdp
                        />

                    </div>

                    {{-- Best Selling --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <div class="form-check form-switch">

                            <input
                                type="hidden"
                                name="is_best_selling"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_best_selling"
                                id="product-is-best-selling"
                                value="1"
                                @checked(old('is_best_selling', $product->is_best_selling))
                            >

                            <label
                                class="form-check-label"
                                for="product-is-best-selling"
                            >
                                محصول پرفروش
                            </label>

                        </div>

                    </div>

                    {{-- Main Image --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.file-upload
                            name="image"
                            id="product-image"
                            label="تصویر اصلی محصول"
                            :multiple="false"
                            :allowReorder="false"
                            :maxFiles="1"
                            :existingFile="$imageUrl"
                        />

                    </div>

                    {{-- Submit --}}
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ویرایش محصول
                        </x-admin.forms.button>

                    </div>

                </div>

            </div>

        </div>
    </form>

@endsection

@push('scripts')

    <script src="{{ asset('admin/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    @include('admin.assets.create_js')
    @include('assets.js.jalalidatepicker')

@endpush

