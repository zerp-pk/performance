<?php

use Illuminate\Support\Facades\Route;
use Zerp\Performance\Http\Controllers\Api\DashboardApiController;
use Zerp\Performance\Http\Controllers\Api\EmployeeGoalApiController;
use Zerp\Performance\Http\Controllers\Api\EmployeeReviewApiController;
use Zerp\Performance\Http\Controllers\Api\GoalTypeApiController;
use Zerp\Performance\Http\Controllers\Api\IndicatorCategoryApiController;
use Zerp\Performance\Http\Controllers\Api\PerformanceIndicatorApiController;
use Zerp\Performance\Http\Controllers\Api\ReviewCycleApiController;

Route::prefix('api')->middleware(['api.json'])->group(function () {
    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'performance', 'as' => 'api.performance.'], function () {
        Route::get('dashboard', [DashboardApiController::class, 'index'])->name('dashboard');

        Route::apiResource('review-cycles', ReviewCycleApiController::class);
        Route::apiResource('employee-reviews', EmployeeReviewApiController::class);
        Route::apiResource('employee-goals', EmployeeGoalApiController::class);
        Route::apiResource('indicators', PerformanceIndicatorApiController::class);
        Route::apiResource('goal-types', GoalTypeApiController::class);
        Route::apiResource('indicator-categories', IndicatorCategoryApiController::class);
    });
});
