<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\EmployeeGoalApiRequest;
use Zerp\Performance\Models\PerformanceEmployeeGoal;

class EmployeeGoalApiController extends BaseResourceApiController
{
    protected string $label = 'Employee goal';
    protected array $with = ['employee:id,name', 'goalType:id,name'];
    protected ?string $searchColumn = 'title';

    protected function model(): string
    {
        return PerformanceEmployeeGoal::class;
    }

    protected function permission(): string
    {
        return 'employee-goals';
    }

    public function store(EmployeeGoalApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(EmployeeGoalApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
