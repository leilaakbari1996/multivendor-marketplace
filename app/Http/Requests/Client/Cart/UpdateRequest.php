<?php

namespace App\Http\Requests\Client\Cart;

use App\Constants\Client\CartConstant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:0',
                'max:'.CartConstant::MAX_QUANTITY_PER_ITEM,
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'quantity' => 'تعداد',
        ];
    }
}
