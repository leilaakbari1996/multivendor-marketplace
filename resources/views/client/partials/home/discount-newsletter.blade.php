
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

                            <div class="mb-3">

                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    ایمیل
                                </label>

                                <input
                                    type="email"
                                    class="form-control form-control-lg"
                                    name="email"
                                    id="email"
                                    placeholder="ایمیل خود را وارد کنید"
                                    required
                                >

                            </div>

                            <div class="d-grid gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-dark btn-lg"
                                >
                                    عضویت در خبرنامه
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

