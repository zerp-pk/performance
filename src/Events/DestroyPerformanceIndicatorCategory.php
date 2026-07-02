<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceIndicatorCategory;

class DestroyPerformanceIndicatorCategory
{
    use Dispatchable;

    public function __construct(
        public PerformanceIndicatorCategory $category
    ) {}
}