{{-- resources/views/components/admin/breadcrumb.blade.php --}}

@props([
    'heading' => null,
    'items' => [],
    'current' => null,
])

<div class="secondary-nav">
    <div class="breadcrumbs-container" data-page-heading="{{ $heading }}">
        <header class="header navbar navbar-expand-sm">

            <a
                href="javascript:void(0);"
                class="btn-toggle sidebarCollapse"
                data-placement="bottom"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-menu"
                >
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <div class="d-flex breadcrumb-content">
                <div class="page-header">

                    @if($heading)
                        <div class="page-title">
                            <h3>{{ $heading }}</h3>
                        </div>
                    @endif

                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            @foreach($items as $item)
                                <li class="breadcrumb-item">
                                    <a href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach

                            @if($current)
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $current }}
                                </li>
                            @endif

                        </ol>
                    </nav>

                </div>
            </div>

        </header>
    </div>
</div>
