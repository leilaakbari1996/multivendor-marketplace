@extends('admin.layouts.app')

@push('styles')
    <style>
        .media-card {
            overflow: hidden;
            cursor: pointer;
        }

        .media-card .media-preview {
            height: 180px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .media-card .media-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .media-card .media-icon {
            font-size: 48px;
            opacity: .5;
        }

        .media-card .card-footer {
            min-height: 90px;
        }

        .media-file-name {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[]"
        current="مدیا"
    />

    <div class="row" id="media-list">

        @forelse($media as $item)
            <div
                class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4 media-item"
                data-name="{{ strtolower($item->file_name) }}"
            >
                <div class="card style-6 media-card h-100">

                    <div class="media-preview">

                        @if(str_starts_with($item->mime_type ?? '', 'image/'))
                            <img
                                src="{{ Storage::disk($item->disk)->url($item->file_path) }}"
                                alt="{{ $item->file_name }}"
                                loading="lazy"
                            >
                        @else
                            <span class="media-icon">
                                📄
                            </span>
                        @endif

                    </div>

                    <div class="card-footer">

                        <div class="d-flex justify-content-between align-items-center">
                            <a
                                href="{{ route(
                                    \App\Constants\AdminView::PERFIX_ROUTE . $item->type->value . '.edit',
                                    $item->mediable_id
                                ) }}"
                                class="btn btn-sm btn-light-info"
                            >
                                مشاهده
                            </a>
                            <small class="text-muted">
                                {{ $item->size ? number_format($item->size / 1024, 2) . ' KB' : '-' }}
                            </small>

                        </div>

                        <div class="mt-2">
                            <span class="badge badge-light-primary">
                                {{ $item->type->label() }}
                            </span>
                        </div>

                    </div>

                </div>
            </div>
        @empty

            <div class="col-12">
                <div class="alert alert-info text-center">
                    هیچ رسانه‌ای یافت نشد.
                </div>
            </div>

        @endforelse

    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('input', '#media-search', function () {
            const search = $(this).val().toLowerCase().trim();

            $('.media-item').each(function () {
                const name = $(this).data('name');

                $(this).toggle(
                    !search || name.includes(search)
                );
            });
        });
    </script>
@endpush
