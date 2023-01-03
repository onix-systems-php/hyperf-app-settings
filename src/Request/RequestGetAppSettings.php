<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Request;

use Hyperf\Validation\Request\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RequestGetAppSettings',
    properties: [
        new OA\Property(property: 'categories', type: 'array', items: [new OA\Items(type: 'string')]),
    ],
    type: 'object',
)]
class RequestGetAppSettings extends FormRequest
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
        return [
            'categories' => 'array|filled',
        ];
    }
}
