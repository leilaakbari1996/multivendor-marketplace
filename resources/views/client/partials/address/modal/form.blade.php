{{-- مودال افزودن / ویرایش آدرس --}}
<div
    class="modal fade ad ad-modal"
    id="adModal"
    tabindex="-1"
    aria-labelledby="adModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">

        <form class="modal-content" id="adForm" novalidate>

            <div class="modal-header">
                <h5 class="modal-title" id="adModalTitle">آدرس جدید</h5>

                <x-client.button
                    type="button"
                    variant="link"
                    text-color="reset"
                    icon="mdi:close"
                    class="btn-close"
                    px="2"
                    data-bs-dismiss="modal"
                    aria-label="بستن"
                />
            </div>

            <div class="modal-body">

                <input type="hidden" name="id">

                <div class="row g-3">

                    {{-- عنوان آدرس --}}
                    <div class="col-12">
                        <x-client.forms.input
                            name="title"
                            id="f-title"
                            label="عنوان آدرس"
                            placeholder="مثلاً خانه یا محل کار"
                            maxlength="30"
                            wrapper-class="mb-0"
                            feedback="عنوان آدرس را وارد کنید."
                        />
                    </div>

                    {{-- نام گیرنده --}}
                    <div class="col-md-6">
                        <x-client.forms.input
                            name="recipient_name"
                            id="f-name"
                            label="نام و نام خانوادگی گیرنده"
                            maxlength="60"
                            wrapper-class="mb-0"
                            feedback="نام گیرنده را وارد کنید."
                        />
                    </div>

                    {{-- موبایل --}}
                    <div class="col-md-6">
                        <x-client.forms.input
                            name="recipient_mobile"
                            id="f-phone"
                            label="شماره موبایل گیرنده"
                            class="ltr"
                            inputmode="numeric"
                            maxlength="11"
                            placeholder="09123456789"
                            wrapper-class="mb-0"
                            feedback="شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود."
                        />
                    </div>

                    {{-- استان --}}
                    <div class="col-md-6">
                        <x-client.forms.select
                            name="province_id"
                            id="f-province"
                            label="استان"
                            placeholder="انتخاب کنید"
                            wrapper-class="mb-0"
                            feedback="استان را انتخاب کنید."
                        />
                    </div>

                    {{-- شهرستان --}}
                    <div class="col-md-6">
                        <x-client.forms.select
                            name="county_id"
                            id="f-county"
                            label="شهرستان"
                            placeholder="ابتدا استان را انتخاب کنید"
                            wrapper-class="mb-0"
                            feedback="شهرستان را انتخاب کنید."
                            disabled
                        />
                    </div>

                    {{-- بخش --}}
                    <div class="col-md-6">
                        <x-client.forms.select
                            name="sector_id"
                            id="f-sector"
                            label="بخش"
                            placeholder="ابتدا شهرستان را انتخاب کنید"
                            wrapper-class="mb-0"
                            feedback="بخش را انتخاب کنید."
                            disabled
                        />
                    </div>

                    {{-- شهر --}}
                    <div class="col-md-6">
                        <x-client.forms.select
                            name="city_id"
                            id="f-city"
                            label="شهر"
                            placeholder="ابتدا بخش را انتخاب کنید"
                            wrapper-class="mb-0"
                            feedback="شهر را انتخاب کنید."
                            disabled
                        />
                    </div>

                    {{-- آدرس کامل (کامپوننت textarea نداریم، پس خام می‌ماند) --}}
                    <div class="col-12">
                        <label for="f-address" class="form-label fw-semibold">آدرس کامل</label>

                        <x-client.forms.textarea
                            name="address"
                            id="f-address"
                            label="آدرس کامل"
                            rows="3"
                            placeholder="خیابان، کوچه، ساختمان"
                            wrapper-class="mb-0"
                            feedback="آدرس را کامل‌تر وارد کنید (حداقل ۱۰ حرف)."
                        />

                        <div class="invalid-feedback">
                            آدرس را کامل‌تر وارد کنید (حداقل ۱۰ حرف).
                        </div>
                    </div>

                    {{-- کد پستی --}}
                    <div class="col-md-4">
                        <x-client.forms.input
                            name="postal_code"
                            id="f-postal"
                            label="کد پستی"
                            class="ltr"
                            inputmode="numeric"
                            maxlength="10"
                            placeholder="۱۰ رقم بدون خط تیره"
                            wrapper-class="mb-0"
                            feedback="کد پستی باید ۱۰ رقم باشد."
                        />
                    </div>

                    {{-- پلاک --}}
                    <div class="col-6 col-md-4">
                        <x-client.forms.input
                            name="plaque"
                            id="f-plaque"
                            label="پلاک (اختیاری)"
                            class="ltr"
                            inputmode="numeric"
                            maxlength="5"
                            wrapper-class="mb-0"
                            feedback="پلاک باید عددی بین ۱ تا ۶۵۵۳۵ باشد."
                        />
                    </div>

                    {{-- واحد --}}
                    <div class="col-6 col-md-4">
                        <x-client.forms.input
                            name="unit"
                            id="f-unit"
                            label="واحد (اختیاری)"
                            maxlength="10"
                            wrapper-class="mb-0"
                            feedback="واحد حداکثر ۱۰ حرف باشد."
                        />
                    </div>

                    {{-- آدرس پیش‌فرض --}}
                    <div class="col-12">
                        <x-client.forms.switch
                            name="is_default"
                            id="f-def"
                            label="به‌عنوان آدرس پیش‌فرض"
                        />
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <x-client.button
                    type="button"
                    variant="light"
                    text-color="dark"
                    data-bs-dismiss="modal"
                >
                    انصراف
                </x-client.button>

                {{-- بدون icon: JS هنگام ذخیره با .text() محتوای دکمه را عوض می‌کند --}}
                <x-client.button type="submit" id="adSave" class="ad-btn">
                    ذخیره آدرس
                </x-client.button>
            </div>

        </form>
    </div>
</div>
