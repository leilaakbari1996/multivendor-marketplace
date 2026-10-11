@extends('client.pages.users.layout')

@section('profile-content')

    {{-- اطلاعات حساب --}}
    <div class="profile-card mb-4">
        <div class="profile-card-header">
            <iconify-icon icon="uil:user-circle"></iconify-icon>
            <h5>اطلاعات حساب</h5>
        </div>

        <form id="profileForm"
              class="p-4"
              action="{{ route('profile.update') }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <x-client.forms.input
                        name="user_name"
                        label="نام و نام خانوادگی"
                        icon="uil:user"
                        :value="$user->user_name"
                    />
                </div>

                <div class="col-md-6">
                    <x-client.forms.input
                        name="mobile"
                        label="شماره موبایل"
                        icon="uil:mobile-android"
                        :value="$user->mobile"
                        dir="ltr"
                        disabled
                    />
                </div>
            </div>

            <div class="text-start mt-2">
                <x-client.button type="submit">ذخیره تغییرات</x-client.button>
            </div>
        </form>
    </div>

    {{-- رمز عبور --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <iconify-icon icon="uil:lock"></iconify-icon>
            <h5>{{ $user->password ? 'تغییر رمز عبور' : 'تعیین رمز عبور' }}</h5>
        </div>

        <form id="passwordForm"
              class="p-4"
              action="{{ route('profile.password') }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-12 {{ $user->password ? '' : 'd-none' }}" id="currentPasswordWrapper">
                    <x-client.forms.input
                        type="password"
                        name="current_password"
                        label="رمز فعلی"
                        icon="uil:lock"
                    />
                </div>

                <div class="col-md-6">
                    <x-client.forms.input
                        type="password"
                        name="password"
                        label="رمز جدید"
                        icon="uil:lock-alt"
                    />
                </div>

                <div class="col-md-6">
                    <x-client.forms.input
                        type="password"
                        name="password_confirmation"
                        label="تکرار رمز جدید"
                        icon="uil:lock-alt"
                    />
                </div>
            </div>

            <div class="text-start mt-2">
                <x-client.button type="submit">ذخیره رمز</x-client.button>
            </div>
        </form>
    </div>

@endsection
