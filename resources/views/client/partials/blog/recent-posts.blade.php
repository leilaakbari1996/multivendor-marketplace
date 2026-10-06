@php
    use App\Support\DateHelper;
@endphp
@if(isset($recentPosts) && $recentPosts->isNotEmpty())
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">جدیدترین مطالب</h6>

            @foreach($recentPosts as $recentPost)
                <a
                    href="{{ route('blogs.show', $recentPost->slug) }}"
                    class="recent-post-item d-flex gap-2 align-items-center text-decoration-none mb-3">
                    <div class="recent-post-thumb flex-shrink-0">
                        @if($recentPost->image)
                            <img src="{{ $recentPost->image->url }}" alt="{{ $recentPost->title }}">
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="recent-post-title mb-0">{{ \Illuminate\Support\Str::limit($recentPost->title, 45) }}</p>
                        <small class="text-muted">{{ DateHelper::toJalali($recentPost->published_at, 'Y/m/d') }}</small>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
