<?php

namespace Zerp\Performance\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Zerp\Performance\Models\PerformanceEmployeeGoal;
use Zerp\Performance\Models\PerformanceEmployeeReview;
use Zerp\Performance\Models\PerformanceIndicator;
use Zerp\Performance\Models\PerformanceReviewCycle;

/** Performance module dashboard summary, scoped to the company. */
class DashboardApiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('manage-employee-reviews')) {
                return $this->errorResponse(__('Permission denied'), null, 403);
            }

            $creatorId = creatorId();

            $reviews = PerformanceEmployeeReview::where('created_by', $creatorId);
            $goals = PerformanceEmployeeGoal::where('created_by', $creatorId);

            $stats = [
                'review_cycles' => PerformanceReviewCycle::where('created_by', $creatorId)->count(),
                'total_reviews' => (clone $reviews)->count(),
                'pending_reviews' => (clone $reviews)->whereIn('status', ['pending', 'in_progress'])->count(),
                'completed_reviews' => (clone $reviews)->where('status', 'completed')->count(),
                'total_goals' => (clone $goals)->count(),
                'goals_in_progress' => (clone $goals)->where('status', 'in_progress')->count(),
                'indicators' => PerformanceIndicator::where('created_by', $creatorId)->count(),
            ];

            $recentReviews = PerformanceEmployeeReview::where('created_by', $creatorId)
                ->with(['user:id,name', 'reviewCycle:id,name'])
                ->latest()
                ->limit(5)
                ->get(['id', 'user_id', 'review_cycle_id', 'review_date', 'status', 'rating', 'created_at']);

            return $this->successResponse([
                'stats' => $stats,
                'recent_reviews' => $recentReviews,
            ], __('Dashboard retrieved successfully'));
        } catch (\Throwable $e) {
            Log::error('Performance Dashboard API error', ['e' => $e]);
            return $this->errorResponse(__('Something went wrong'), null, 500);
        }
    }
}
