<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceReviewCycle;

class DestroyReviewCycle
{
    use Dispatchable;

    public function __construct(
        public PerformanceReviewCycle $cycle
    ) {}
}