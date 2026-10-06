@props([
    'minName' => 'min_price',
    'maxName' => 'max_price',
    'label' => 'محدوده قیمت',
    'unit' => 'تومان',
    'errorId' => 'priceError',
])

<div class="mb-4">

    <label class="form-label fw-semibold">{{ $label }}</label>

    <div class="row g-2">

        <div class="col-6">
            <div class="input-group">
                <input
                    type="number"
                    id="{{ $minName }}"
                    name="{{ $minName }}"
                    class="form-control rounded-3"
                    value="{{ request($minName) }}"
                    placeholder="از"
                    min="0"
                    step="1000"
                >
                <span class="input-group-text border-0 bg-transparent">{{ $unit }}</span>
            </div>
        </div>

        <div class="col-6">
            <div class="input-group">
                <input
                    type="number"
                    id="{{ $maxName }}"
                    name="{{ $maxName }}"
                    class="form-control rounded-3"
                    value="{{ request($maxName) }}"
                    placeholder="تا"
                    min="0"
                    step="1000"
                >
                <span class="input-group-text border-0 bg-transparent">{{ $unit }}</span>
            </div>
        </div>

    </div>

    <small id="{{ $errorId }}" class="text-danger d-none mt-2 d-block">
        مقدار «تا» باید بزرگ‌تر از مقدار «از» باشد.
    </small>

</div>
