<?php

namespace App\Http\Requests\Client\Contact;

use App\Enums\ContactSubject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^09\d{9}$/',
            ],

            'email' => [
                'nullable',
                'string',
                'email:rfc',
                'max:255',
            ],

            'subject' => [
                'required',
                'string',
                Rule::enum(ContactSubject::class),
            ],

            'message' => [
                'required',
                'string',
                'max:10000',
            ],
        ];
    }
}
