<?php

namespace Zerp\Performance\Providers;

use Illuminate\Support\ServiceProvider;

class PerformanceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $routesPath = __DIR__.'/../Routes/web.php';
        if (file_exists($routesPath)) {
            $this->loadRoutesFrom($routesPath);
        }

        $apiRoutesPath = __DIR__.'/../Routes/api.php';
        if (file_exists($apiRoutesPath)) {
            $this->loadRoutesFrom($apiRoutesPath);
        }

        // Scoped Swagger/OpenAPI docs for this module at /docs/performance.
        if (class_exists(\Dedoc\Scramble\Scramble::class)) {
            \Dedoc\Scramble\Scramble::registerApi('performance', [
                'api_path' => 'api/performance',
                'info' => ['version' => \Composer\InstalledVersions::getPrettyVersion('zerp/performance') ?? '1.0.0', 'description' => 'Zerp Performance module REST API for mobile and third-party clients.'],
                'ui' => ['title' => 'Zerp Performance API'],
            ])->expose(ui: '/docs/performance', document: '/docs/performance.json');
        }

        $migrationsPath = __DIR__.'/../Database/Migrations';
        if (is_dir($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
}