@props([
    'type',
    'id',
    'isLiked' => false,
])

<button
    type="button"
    class="btn-wishlist position-absolute top-0 end-0 m-3 {{ $isLiked ? 'active' : '' }}"
    data-like
    data-likeable-type="{{ $type }}"
    data-likeable-id="{{ $id }}"
    aria-label="{{ $isLiked ? 'حذف لایک' : 'افزودن به علاقه‌مندی' }}"
>
    <svg width="24" height="24">
        <use href="#heart"></use>
    </svg>
</button>
