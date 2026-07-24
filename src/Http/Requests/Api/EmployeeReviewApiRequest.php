<?php

namespace Zerp\Performance\Http\Requests\Api;

use App\Http\Requests\ApiFormRequest;

/** Body for creating/updating an employee review (appraisal). */
class EmployeeReviewApiRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id,created_by,' . creatorId(),
            'reviewer_id' => 'required|exists:users,id,created_by,' . creatorId(),
            'review_cycle_id' => 'required|exists:performance_review_cycles,id,created_by,' . creatorId(),
            'review_date' => 'required|date',
            'completion_date' => 'nullable|date',
            'rating' => 'nullable|numeric|min:0|max:10',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ];
    }
}
