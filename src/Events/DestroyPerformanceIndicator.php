<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceIndicator;

class DestroyPerformanceIndicator
{
    use Dispatchable;

    public function __construct(
        public PerformanceIndicator $indicator
    ) {}
}