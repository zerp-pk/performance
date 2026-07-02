<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceEmployeeGoal;

class DestroyEmployeeGoal
{
    use Dispatchable;

    public function __construct(
        public PerformanceEmployeeGoal $goal
    ) {}
}