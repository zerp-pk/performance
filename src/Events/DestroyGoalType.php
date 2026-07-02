<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceGoalType;

class DestroyGoalType
{
    use Dispatchable;

    public function __construct(
        public PerformanceGoalType $goalType
    ) {}
}