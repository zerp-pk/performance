<?php

namespace Zerp\Performance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zerp\Performance\Models\PerformanceEmployeeReview;

class DestroyEmployeeReview
{
    use Dispatchable;

    public function __construct(
        public PerformanceEmployeeReview $review
    ) {}
}