<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\GoalTypeApiRequest;
use Zerp\Performance\Models\PerformanceGoalType;

class GoalTypeApiController extends BaseResourceApiController
{
    protected string $label = 'Goal type';

    protected function model(): string
    {
        return PerformanceGoalType::class;
    }

    protected function permission(): string
    {
        return 'goal-types';
    }

    public function store(GoalTypeApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(GoalTypeApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
