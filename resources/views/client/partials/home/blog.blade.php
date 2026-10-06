
<section id="latest-blog" class="py-5">
    <div class="container-fluid">

        <div class="row">
            <div class="section-header d-flex align-items-center justify-content-between my-5">
                <h2 class="section-title">آخرین مطالب وبلاگ</h2>

                <div class="btn-wrap align-right">
                    <a href="{{ route('blogs.index') }}" class="d-flex align-items-center nav-link">
                        مشاهده همه مقالات ←
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($latestPosts as $post)
                <div class="col-md-4">
                    <x-client.blog-card :post="$post" />
                </div>
            @endforeach
        </div>

    </div>
</section>

