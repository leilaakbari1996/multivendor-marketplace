@extends('client.pages.users.layout')

@section('profile-content')
    <section>
        <div class="card-box p-4" id="orders-card">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h1 class="h6 fw-bold d-inline m-0">سفارش‌های من</h1>
                    <span class="text-secondary me-2" id="orders-count">{{ number_format($orders->total()) }} سفارش</span>
                </div>

                {{-- لینک‌های واقعی‌اند (بدون JS هم کار می‌کنند)؛ orders.js آن‌ها را AJAX می‌کند --}}
                <ul class="nav nav-pills gap-2 flex-wrap" id="orders-filters">
                    <li class="nav-item">
                        <a class="nav-link {{ $status === null ? 'active' : '' }}"
                           data-status=""
                           href="{{ route('profile.orders.index') }}">همه</a>
                    </li>
                    @foreach ($statuses as $case)
                        <li class="nav-item">
                            <a class="nav-link {{ $status === $case ? 'active' : '' }}"
                               data-status="{{ $case->value }}"
                               href="{{ route('profile.orders.index', ['status' => $case->value]) }}">
                                {{ $case->label() }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div id="orders-list">
                @include('client.partials.order.list')
            </div>

        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/custom/css/orders.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('client/custom/js/orders.js') }}"></script>
@endpush
