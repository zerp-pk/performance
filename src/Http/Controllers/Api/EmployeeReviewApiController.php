<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\EmployeeReviewApiRequest;
use Zerp\Performance\Models\PerformanceEmployeeReview;

class EmployeeReviewApiController extends BaseResourceApiController
{
    protected string $label = 'Employee review';
    protected array $with = ['user:id,name', 'reviewer:id,name', 'reviewCycle:id,name'];
    protected ?string $searchColumn = null;

    protected function model(): string
    {
        return PerformanceEmployeeReview::class;
    }

    protected function permission(): string
    {
        return 'employee-reviews';
    }

    public function store(EmployeeReviewApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(EmployeeReviewApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
