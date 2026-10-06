<?php

namespace App\Http\Requests\Admin\Setting;

use App\Settings\SiteSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (SiteSettings::definitions() as $setting) {

            $rule = [];

            if ($setting['required'] ?? false) {
                $rule[] = 'required';
            } else {
                $rule[] = 'nullable';
            }

            switch ($setting['type']) {

                case 'image':
                    $rule[] = File::types([
                        'jpg',
                        'jpeg',
                        'png',
                        'webp',
                        'gif',
                    ]);
                    break;

                case 'email':
                    $rule[] = 'email';
                    break;

                case 'textarea':
                case 'text':
                    $rule[] = 'string';
                    break;
            }

            $rules[$setting['name']] = $rule;
        }

        return $rules;
    }

    public function attributes(): array
    {
        return collect(SiteSettings::definitions())
            ->mapWithKeys(fn (array $setting) => [
                $setting['name'] => $setting['label'],
            ])
            ->toArray();
    }
}
