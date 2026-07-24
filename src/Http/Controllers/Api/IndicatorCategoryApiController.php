<?php

namespace Zerp\Performance\Http\Controllers\Api;

use Zerp\Performance\Http\Requests\Api\IndicatorCategoryApiRequest;
use Zerp\Performance\Models\PerformanceIndicatorCategory;

class IndicatorCategoryApiController extends BaseResourceApiController
{
    protected string $label = 'Indicator category';

    protected function model(): string
    {
        return PerformanceIndicatorCategory::class;
    }

    protected function permission(): string
    {
        return 'performance-indicator-categories';
    }

    public function store(IndicatorCategoryApiRequest $request)
    {
        return $this->applyStore($request->validated());
    }

    public function update(IndicatorCategoryApiRequest $request, $id)
    {
        return $this->applyUpdate($id, $request->validated());
    }
}
