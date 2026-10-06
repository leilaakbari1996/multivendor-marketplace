@extends('client.pages.users.layout')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('client/custom/css/address.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" rel="stylesheet">
@endpush

@section('profile-content')
    <section class="ad" id="adSection">
        <div class="ad-card">
            <div class="ad-head">
                <h2>آدرس‌های من <small id="adCount"></small></h2>
                <x-client.button type="button" id="adNew" class="ad-btn">
                    افزودن آدرس جدید
                </x-client.button>
            </div>
            <div id="adList"></div>
        </div>
    </section>

    @include('client.partials.address.modal.form')

    <!-- مودال تأیید حذف -->
    <div class="modal fade ad ad-modal" id="adDel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center pt-4">
                    <i class="bi bi-trash3" style="font-size:2.2rem;color:var(--c-red)"></i>
                    <h6 class="mt-3 fw-bold">این آدرس حذف شود؟</h6>
                    <p class="small text-muted mb-0" id="adDelTxt"></p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <button type="button" class="ad-btn ghost" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" class="ad-btn danger" id="adDelOk">بله، حذف شود</button>
                </div>
            </div>
        </div>
    </div>
    <div class="ad-toast" id="adToast" role="status"></div>
@endsection

@push('scripts')
    <script>
        window.addressConfig = {
            addresses: @json($addresses),
            routes: {
                store:   '{{ route('profile.addresses.store') }}',
                update:  '{{ route('profile.addresses.update', ':id') }}',
                destroy: '{{ route('profile.addresses.destroy', ':id') }}',
                def:     '{{ route('profile.addresses.default', ':id') }}',

                provinces: "{{ route('locations.provinces') }}",
                counties:  "{{ route('locations.counties', ':id') }}",
                sectors:   "{{ route('locations.sectors', ':id') }}",
                cities:    "{{ route('locations.cities', ':id') }}",
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('client/custom/js/address.js') }}"></script>
    <script src="{{ asset('client/custom/js/address-action.js') }}"></script>
@endpush
