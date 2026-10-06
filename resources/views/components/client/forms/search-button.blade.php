@props([
    'text' => 'اعمال فیلتر',

])

<button
    type="submit"
    {{ $attributes->merge([
        'class' => 'btn btn-brand rounded-3 py-2 fw-semibold',
    ]) }}
    data-submit-btn
>
    <i class="bi bi-funnel me-1"></i>
    {{ $text }}
</button>


<a href="{{ url()->current() }}" class="btn btn-light border rounded-3 py-2 clear-filters-link">
    <i class="bi bi-x-lg me-1"></i>
    حذف فیلترها
</a>


