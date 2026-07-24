<?php

namespace Zerp\Performance\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Shared CRUD skeleton for the performance module's six resources, which are
 * identical apart from model, permission slug, eager loads, and search field.
 * The index/show/destroy flow lives here; each subclass supplies the config
 * and its own typed store()/update() so the FormRequests keep validating and
 * Scramble keeps reading their schemas.
 *
 * ponytail: one base for six real subclasses, not speculative indirection.
 * Every action re-queries by $id with the tenant scope because route-model
 * binding does not run under the api.json middleware.
 */
abstract class BaseResourceApiController extends Controller
{
    use ApiResponseTrait;

    /** Eloquent model class this controller manages. */
    abstract protected function model(): string;

    /** Permission suffix, e.g. 'review-cycles' -> manage-review-cycles, create-review-cycles. */
    abstract protected function permission(): string;

    /** Relations to eager load on index/show. */
    protected array $with = [];

    /** Column to match against ?search=, or null to disable. */
    protected ?string $searchColumn = 'name';

    /** Human label used in messages, e.g. 'Review cycle'. */
    protected string $label = 'Record';

    protected function ownerScope($query)
    {
        return $query->where(function ($q) {
            if (Auth::user()->can('manage-any-' . $this->permission())) {
                $q->where('created_by', creatorId());
            } elseif (Auth::user()->can('manage-own-' . $this->permission())) {
                $q->where('creator_id', Auth::id());
            } else {
                $q->whereRaw('1 = 0');
            }
        });
    }

    protected function findOwned($id)
    {
        $model = $this->model();

        return $this->ownerScope($model::where('id', $id))->with($this->with)->first();
    }

    /** Create with the caller's ownership stamped on. Call from a subclass store(). */
    protected function createOwned(array $data)
    {
        $model = $this->model();

        return $model::create($data + [
            'creator_id' => Auth::id(),
            'created_by' => creatorId(),
        ]);
    }

    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('manage-' . $this->permission())) {
                return $this->errorResponse(__('Permission denied'), null, 403);
            }

            $model = $this->model();
            $records = $this->ownerScope($model::query())
                ->with($this->with)
                ->when($this->searchColumn && $request->search, fn ($q) => $q->where($this->searchColumn, 'like', '%' . $request->search . '%'))
                ->when($request->status, fn ($q) => $q->where('status', $request->status))
                ->latest()
                ->paginate($request->get('per_page', 10))
                ->withQueryString();

            return $this->paginatedResponse($records, __(':label list retrieved successfully', ['label' => $this->label]));
        } catch (\Throwable $e) {
            Log::error($this->label . ' API index error', ['e' => $e]);
            return $this->errorResponse(__('Something went wrong'), null, 500);
        }
    }

    public function show($id)
    {
        try {
            if (!Auth::user()->can('manage-' . $this->permission())) {
                return $this->errorResponse(__('Permission denied'), null, 403);
            }

            $record = $this->findOwned($id);
            if (!$record) {
                return $this->errorResponse(__(':label not found', ['label' => $this->label]), null, 404);
            }

            return $this->successResponse($record, __(':label details retrieved successfully', ['label' => $this->label]));
        } catch (\Throwable $e) {
            Log::error($this->label . ' API show error', ['e' => $e]);
            return $this->errorResponse(__('Something went wrong'), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('delete-' . $this->permission())) {
                return $this->errorResponse(__('Permission denied'), null, 403);
            }

            $record = $this->findOwned($id);
            if (!$record) {
                return $this->errorResponse(__(':label not found', ['label' => $this->label]), null, 404);
            }

            $record->delete();

            return $this->successResponse(null, __(':label deleted successfully', ['label' => $this->label]));
        } catch (\Throwable $e) {
            Log::error($this->label . ' API destroy error', ['e' => $e]);
            return $this->errorResponse(__('Something went wrong'), null, 500);
        }
    }

    /** Shared body for a subclass update() once it has validated its request. */
    protected function applyUpdate($id, array $data)
    {
        if (!Auth::user()->can('edit-' . $this->permission())) {
            return $this->errorResponse(__('Permission denied'), null, 403);
        }

        $record = $this->findOwned($id);
        if (!$record) {
            return $this->errorResponse(__(':label not found', ['label' => $this->label]), null, 404);
        }

        $record->update($data);

        return $this->successResponse($record->fresh($this->with), __(':label updated successfully', ['label' => $this->label]));
    }

    /** Shared body for a subclass store() once it has validated its request. */
    protected function applyStore(array $data)
    {
        if (!Auth::user()->can('create-' . $this->permission())) {
            return $this->errorResponse(__('Permission denied'), null, 403);
        }

        $record = $this->createOwned($data);

        return $this->successResponse($record->fresh($this->with), __(':label created successfully', ['label' => $this->label]), 201);
    }
}
