{{--
    Usage:
        <x-client.pagination :paginator="$products->withQueryString()" />

    Requires: $paginator to be an instance of Illuminate\Pagination\LengthAwarePaginator
--}}

@if ($paginator->hasPages())

    <nav aria-label="صفحه‌بندی محصولات" class="custom-pagination">
        <ul class="pagination justify-content-center gap-1 mb-0">

            {{-- Previous (visually points right in RTL) --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                @if ($paginator->onFirstPage())
                    <span class="page-link" aria-disabled="true">
                        <svg width="18" height="18"><use xlink:href="#arrow-right"></use></svg>
                    </span>
                @else
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="صفحه قبل">
                        <svg width="18" height="18"><use xlink:href="#arrow-right"></use></svg>
                    </a>
                @endif
            </li>

            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $onEachSide = 1;
                $start = max($current - $onEachSide, 1);
                $end = min($current + $onEachSide, $last);
            @endphp

            {{-- First page + leading ellipsis --}}
            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>

                @if ($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link">…</span>
                    </li>
                @endif
            @endif

            {{-- Page window around current page --}}
            @for ($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $page == $current ? 'active' : '' }}">
                    @if ($page == $current)
                        <span class="page-link" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    @endif
                </li>
            @endfor

            {{-- Trailing ellipsis + last page --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <li class="page-item disabled">
                        <span class="page-link">…</span>
                    </li>
                @endif

                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next (visually points left in RTL — same arrow icon, flipped) --}}
            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                @if ($paginator->hasMorePages())
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="صفحه بعد">
                        <svg width="18" height="18" class="icon-flip"><use xlink:href="#arrow-right"></use></svg>
                    </a>
                @else
                    <span class="page-link" aria-disabled="true">
                        <svg width="18" height="18" class="icon-flip"><use xlink:href="#arrow-right"></use></svg>
                    </span>
                @endif
            </li>

        </ul>
    </nav>

@endif

<style>
    .custom-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
    }

    .custom-pagination .page-item .page-link {
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid #eee;
        color: #374151;
        font-weight: 600;
        font-size: 0.9rem;
        background-color: #fff;
        transition: background-color .15s ease-in-out, color .15s ease-in-out, border-color .15s ease-in-out;
    }

    .custom-pagination .page-item:not(.disabled) .page-link:hover {
        background-color: rgba(245, 158, 11, 0.1);
        border-color: var(--brand-color, #f59e0b);
        color: var(--brand-color-dark, #d97706);
    }

    .custom-pagination .page-item.active .page-link {
        background-color: var(--brand-color, #f59e0b);
        border-color: var(--brand-color, #f59e0b);
        color: #fff;
    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: #f9fafb;
        color: #d1d5db;
        border-color: #eee;
        cursor: not-allowed;
    }

    .custom-pagination .page-link svg {
        display: block;
    }

    .icon-flip {
        transform: scaleX(-1);
    }
</style>
