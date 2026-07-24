<?php

namespace Zerp\Performance\Http\Requests\Api;

use App\Http\Requests\ApiFormRequest;

/** Body for creating/updating a performance indicator category. */
class IndicatorCategoryApiRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
