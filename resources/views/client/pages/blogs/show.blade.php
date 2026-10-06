@extends('client.layouts.app')

@section('title', 'محصولات')

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/blog-show.css') }}"
    >
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/breadcrumb.css') }}"
    >
    <link rel="stylesheet"
          type="text/css"
          href="{{ asset('client/custom/css/recent-post.css') }}">

@endpush

@section('content')


    <div class="bp-progress" id="bpProgress"></div>
    <main class="bp">
        <div class="container">

            <x-client.breadcrumb
                :items="[
                    ['title' => 'وبلاگ', 'url' => route('blogs.index')],
                ]"
                :current="$post->title"
            />

            <div class="row g-4">

                <!-- مقاله (سمت راست) -->
                <div class="col-lg-8">
                    <article class="bp-card" id="bpArticle">
                        <div class="bp-cover">
                            <img src="{{ $post->image->url }}" alt="{{ $post->title }}" onerror="this.style.visibility='hidden'">
                        </div>

                        <div class="bp-meta">
                            <a href="#" class="cat">راهنمای خرید</a>
                            <span><i class="bi bi-calendar3"></i>1405/07/08</span>
                            <span><i class="bi bi-clock"></i><b id="readTime">۵</b> دقیقه مطالعه</span>
                            <span><i class="bi bi-person"></i>تیم مارکت هاب</span>
                        </div>

                        <h1 class="bp-title">{{ $post->title }}</h1>
                        <p class="bp-lead">قبل از خرید محصولات مختلف، بهتر است به چند نکته مهم درباره کیفیت آن‌ها توجه کنید تا خریدی مطمئن و به‌صرفه داشته باشید.</p>

                        <!-- لاراول: {!! $post->content !!} -->
                        <div class="bp-body" id="bpBody">
                            {!! $post->content !!}
                        </div>

                        <div class="bp-foot">
                            <div class="bp-tags">
                                <a href="#">کیفیت</a><a href="#">سبزیجات</a><a href="#">راهنمای خرید</a>
                            </div>
                            <div class="bp-share">
                                <span>اشتراک‌گذاری</span>
                                <a id="shTg" target="_blank" rel="noopener" aria-label="تلگرام"><i class="bi bi-telegram"></i></a>
                                <a id="shWa" target="_blank" rel="noopener" aria-label="واتساپ"><i class="bi bi-whatsapp"></i></a>
                                <button type="button" id="shCopy" aria-label="کپی لینک"><i class="bi bi-link-45deg"></i></button>
                            </div>
                        </div>

                        @php($author = $post->author)

                        <div class="bp-author">
                            <div class="bp-avatar">{{ mb_substr($author?->user_name ?? 'م', 0, 1) }}</div>
                            <div>
                                <b>{{ $post->author?->user_name ?? 'تیم مارکت هاب' }}</b>
                                <p> ما سعی می‌کنیم هر هفته نکات کاربردی برای خرید بهتر و سالم‌تر به شما معرفی کنیم.</p>
                            </div>
                        </div>

                        @if($prev || $next)
                            <div class="bp-nav">
                                @if($prev)
                                    <a href="{{ route('blogs.show', $prev) }}" class="pv" rel="prev">
                                        <small><i class="bi bi-arrow-right"></i> مطلب قبلی</small>
                                        <b>{{ $prev->title }}</b>
                                    </a>
                                @endif

                                @if($next)
                                    <a href="{{ route('blogs.show', $next) }}" class="nx" rel="next">
                                        <small>مطلب بعدی <i class="bi bi-arrow-left"></i></small>
                                        <b>{{ $next->title }}</b>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </article>
                </div>

                <!-- سایدبار (سمت چپ) -->
                <aside class="col-lg-4">
                    @include('client.partials.blog.recent-posts')
                </aside>
            </div>
        </div>
    </main>
    <div class="bp-toast" id="bpToast" role="status"></div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            var $body = $('#bpBody'), $art = $('#bpArticle'), $win = $(window), $h2 = $body.find('h2');

            // زمان مطالعه
            $('#readTime').text(Math.max(1, Math.round($body.text().trim().split(/\s+/).length / 180)));

            // ساخت فهرست مطالب از تیترهای h2 (برای دسکتاپ و موبایل)
            var toc = '';
            $h2.each(function (i) { var id = 'sec-' + (i + 1); $(this).attr('id', id); toc += '<a href="#' + id + '">' + $(this).text() + '</a>'; });
            if ($h2.length > 1) {
                $('.bp-toc-list').html(toc);
                $('<details class="bp-toc-m d-lg-none"><summary>فهرست مطالب</summary><nav class="bp-toc-list">' + toc + '</nav></details>').insertBefore($body);
            } else { $('.bp-side .d-lg-block').remove(); }

            $(document).on('click', '.bp-toc-list a', function (e) {
                e.preventDefault();
                $('html,body').animate({ scrollTop: $($(this).attr('href')).offset().top - 90 }, 400);
                $(this).closest('details').removeAttr('open');
            });

            // نوار پیشرفت مطالعه + مشخص کردن بخش فعلی
            function onScroll() {
                var st = $win.scrollTop(), start = $art.offset().top, end = start + $art.outerHeight() - $win.height();
                $('#bpProgress').css('width', Math.min(100, Math.max(0, (st - start) / Math.max(end - start, 1) * 100)) + '%');
                var cur = null;
                $h2.each(function () { if ($(this).offset().top - st < 140) cur = this.id; });
                $('.bp-toc-list a').removeClass('active').filter('[href="#' + cur + '"]').addClass('active');
            }
            $win.on('scroll resize', onScroll); onScroll();

            // اشتراک‌گذاری
            var url = encodeURIComponent(location.href), t = encodeURIComponent(document.title);
            $('#shTg').attr('href', 'https://t.me/share/url?url=' + url + '&text=' + t);
            $('#shWa').attr('href', 'https://wa.me/?text=' + t + '%20' + url);
            var tm;
            $('#shCopy').on('click', function () {
                var done = function () { var $x = $('#bpToast').text('لینک مطلب کپی شد').addClass('show'); clearTimeout(tm); tm = setTimeout(function () { $x.removeClass('show'); }, 2000); };
                if (navigator.clipboard) navigator.clipboard.writeText(location.href).then(done);
            });
        });
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('admin/custom/js/ajax.js') }}"></script>
@endpush


