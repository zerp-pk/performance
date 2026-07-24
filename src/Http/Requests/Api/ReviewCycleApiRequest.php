<?php

namespace Zerp\Performance\Http\Requests\Api;

use App\Http\Requests\ApiFormRequest;

/** Body for creating/updating a performance review cycle. */
class ReviewCycleApiRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'frequency' => 'required|in:monthly,quarterly,semi-annual,annual',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
