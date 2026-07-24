<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\PerformanceIndicatorApiRequest;
use Zerp\Performance\Models\PerformanceIndicator;

class PerformanceIndicatorApiController extends BaseResourceApiController
{
    protected string $label = 'Performance indicator';
    protected array $with = ['category:id,name'];

    protected function model(): string
    {
        return PerformanceIndicator::class;
    }

    protected function permission(): string
    {
        return 'performance-indicators';
    }

    public function store(PerformanceIndicatorApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(PerformanceIndicatorApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
