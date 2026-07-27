<?php

namespace Zerp\Performance\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Zerp\Performance\Providers\PerformanceServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [PerformanceServiceProvider::class];
    }
}
