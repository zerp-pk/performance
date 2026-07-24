<?php

namespace Zerp\Performance\Http\Requests\Api;

use App\Http\Requests\ApiFormRequest;

/** Body for creating/updating a performance indicator (competency). */
class PerformanceIndicatorApiRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:performance_indicator_categories,id,created_by,' . creatorId(),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'measurement_unit' => 'required|string|max:100',
            'target_value' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
