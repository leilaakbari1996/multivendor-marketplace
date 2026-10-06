@props([
    'showUrl' => null,
    'editUrl' => null,
    'deleteUrl' => null,
])

<div class="d-flex align-items-center gap-2">

    @if($showUrl)
        <a
            href="{{ $showUrl }}"
            class="btn btn-sm btn-light-info d-flex align-items-center justify-content-center"
            title="مشاهده"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </a>
    @endif

    @if($editUrl)
        <a
            href="{{ $editUrl }}"
            class="btn btn-sm btn-light-primary d-flex align-items-center justify-content-center"
            title="ویرایش"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
            </svg>
        </a>
    @endif

    @if($deleteUrl)
        <button
            type="button"
            class="btn btn-sm btn-light-danger d-flex align-items-center justify-content-center delete-item"
            data-url="{{ $deleteUrl }}"
            title="حذف"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                <path d="M10 11v6"></path>
                <path d="M14 11v6"></path>
                <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
            </svg>
        </button>
    @endif

</div>
