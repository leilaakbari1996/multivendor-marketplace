@php
    use App\Support\AuthUser;
    $user = AuthUser::user();
@endphp

@extends('client.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/custom/css/user.css') }}">
@endpush

@section('content')
    <section class="profile-page py-5">
        <div class="container">
            <div class="row g-4">

                {{-- منوی کناری --}}
                <aside class="col-lg-3">
                    <div class="profile-card">
                        <div class="text-center p-4 border-bottom">

                            {{-- آواتار قابل تغییر --}}
                            <form id="avatarForm"
                                  class="mb-3"
                                   action="{{ route('profile.avatar') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <label for="avatarInput" class="sidebar-avatar mx-auto" title="تغییر عکس پروفایل">
                                    <span class="sidebar-avatar-circle">
                                        @if ($user->avatar ?? false)
                                            <img src="{{ $user->avatar->url }}" alt="{{ $user->user_name }}"
                                                 id="avatarPreview">
                                        @else
                                            <span class="sidebar-avatar-letter" id="avatarPlaceholder">
                                                {{ mb_substr($user->user_name ?: 'ک', 0, 1) }}
                                            </span>
                                            <img src="" alt="" class="d-none" id="avatarPreview">
                                        @endif
                                    </span>

                                    {{-- آیکون دوربین کنار عکس --}}
                                    <span class="sidebar-avatar-badge">
                                        <svg width="16" height="16"><use href="#camera"></use></svg>
                                    </span>
                                </label>

                                <input type="file" id="avatarInput" name="avatar"
                                       accept="image/png,image/jpeg,image/webp" class="d-none">

                                @error('avatar')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </form>

                            <h6 class="mb-1">{{ $user->user_name ?: 'کاربر' }}</h6>
                            <small class="text-muted" dir="ltr">{{ $user->mobile }}</small>
                        </div>

                        <nav class="profile-menu">
                            <a href="{{ route('profile.index') }}"
                               class="{{ request()->routeIs('profile.index') ? 'active' : '' }}">
                                <iconify-icon icon="uil:user"></iconify-icon>
                                اطلاعات حساب
                            </a>
                            <a href="{{ route('profile.orders.index') }}"
                               class="{{ request()->routeIs('profile.orders.index') ? 'active' : '' }}">
                                <iconify-icon icon="uil:box"></iconify-icon>
                                سفارش‌های من
                            </a>
                            <a href="{{ route('profile.addresses.index') }}"
                               class="{{ request()->routeIs('profile.addresses.index') ? 'active' : '' }}">
                                <iconify-icon icon="uil:map-marker"></iconify-icon>
                                آدرس‌ها
                            </a>
                            <a href="{{ route('profile.likes') }}"
                               class="{{ request()->routeIs('profile.likes') ? 'active' : '' }}">
                                <iconify-icon icon="uil:heart"></iconify-icon>
                                علاقه‌مندی‌ها
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-danger">
                                    <iconify-icon icon="uil:signout"></iconify-icon>
                                    خروج
                                </button>
                            </form>
                        </nav>
                    </div>
                </aside>

                {{-- محتوا --}}
                <div class="col-lg-9">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('profile-content')
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/user.js') }}"></script>
@endpush
