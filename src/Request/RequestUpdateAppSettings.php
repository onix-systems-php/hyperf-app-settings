<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Request;

use Hyperf\Validation\Request\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RequestUpdateAppSettings",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="SETTING_EXAMPLE_STRING"),
 *     @OA\Property(property="value", type="object", example="<TYPE_RELATED_VALUE>"),
 * )
 */
class RequestUpdateAppSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rule = 'required';
        return [
            'name' => $rule,
            'value' => [$rule, 'array'],
        ];
    }
}
