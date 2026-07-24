<?php

namespace Zerp\Performance\Http\Requests\Api;

use App\Http\Requests\ApiFormRequest;

/** Body for creating/updating an employee goal. */
class EmployeeGoalApiRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'goal_type_id' => 'required|exists:performance_goal_types,id,created_by,' . creatorId(),
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target' => 'required|string|max:50',
            'progress' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:not_started,in_progress,completed,overdue',
        ];
    }
}
