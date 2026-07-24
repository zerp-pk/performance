<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\ReviewCycleApiRequest;
use Zerp\Performance\Models\PerformanceReviewCycle;

class ReviewCycleApiController extends BaseResourceApiController
{
    protected string $label = 'Review cycle';

    protected function model(): string
    {
        return PerformanceReviewCycle::class;
    }

    protected function permission(): string
    {
        return 'review-cycles';
    }

    public function store(ReviewCycleApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(ReviewCycleApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
