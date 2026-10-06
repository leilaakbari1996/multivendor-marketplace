<?php

namespace App\Http\Requests\Client\Like;

use App\Support\AuthUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LikeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AuthUser::check();
    }

    public function rules(): array
    {
        return [
            'likeable_type' => [
                'required',
                Rule::in([
                    'product',
                    'post',
                ]),
            ],

            'likeable_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
