
<section class="py-5">
    <div class="container-fluid">

        <div
            class="bg-secondary py-5 my-5 rounded-5"
            style="background: url('{{ asset('client/images/bg-leaves-img-pattern.png') }}') no-repeat;"
        >
            <div class="container my-5">

                <div class="row align-items-center">

                    {{-- Content --}}
                    <div class="col-md-6 p-5">

                        <div class="section-header">
                            <h2 class="section-title display-4">
                                <span class="text-primary">۲۵٪ تخفیف</span>
                                برای اولین خرید شما
                            </h2>
                        </div>

                        <p>
                            با عضویت در خبرنامه، از جدیدترین محصولات،
                            تخفیف‌ها و پیشنهادهای ویژه باخبر شوید.
                        </p>

                    </div>

                    {{-- Newsletter Form --}}
                    <div class="col-md-6 p-5">

                        <form
                            action="{{ route('newsletter.subscribe') }}"
                            method="POST"
                            class="newsletter-form"
                        >
                            @csrf

                            <x-client.forms.input
                                name="email"
                                id="email"
                                type="email"
                                placeholder="ایمیل خود را وارد کنید"
                                required
                                class="mb-4"
                            />

                            <div class="d-grid gap-2">

                                <x-client.button
                                    type="submit"
                                    variant="dark"
                                    class="btn-lg"
                                >
                                    عضویت در خبرنامه
                                </x-client.button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

