<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Banner;

use App\Enums\BannerPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

/**
 * Rules shared by the store and update requests.
 * Child classes only decide whether the image is required.
 */
abstract class BaseBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is handled by BannerPolicy in the controller.
        return true;
    }

    /**
     * An unchecked switch sends nothing, so make the value explicit.
     * Without this, turning a banner off would silently keep it active.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],

            // Only http/https, to block "javascript:" and similar schemes.
            'url' => ['nullable', 'url:http,https', 'max:2048'],

            'position' => ['required', Rule::enum(BannerPosition::class)],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],

            'image' => $this->imageRules(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    abstract protected function imageRules(): array;

    /**
     * The file constraints used by every child request.
     */
    protected function imageFileRule(): File
    {
        return File::image()
            ->types(['jpg', 'jpeg', 'png', 'webp'])
            ->max('2mb')
            // Guards against huge-pixel images that exhaust memory when decoded.
            ->dimensions(Rule::dimensions()->maxWidth(4000)->maxHeight(4000));
    }
}
