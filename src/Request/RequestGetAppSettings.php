<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Request;

use Hyperf\Validation\Request\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RequestGetAppSettings",
 *     type="object",
 *     @OA\Property(property="categories", type="array", @OA\Items(type="string")),
 * )
 */
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
