<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfAppSettings\Request;

use Hyperf\Validation\Request\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RequestUpdateAppSettings',
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'SETTING_EXAMPLE_STRING'),
        new OA\Property(property: 'value', type: 'object', example: '<TYPE_RELATED_VALUE>'),
    ],
    type: 'object',
)]
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
