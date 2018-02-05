<?php

namespace App\Http\Controllers\Api;

use App\Events\FeedbackedEvent;
use App\Http\Controllers\ApiController;
use App\Models\Feedback;
use Request;

class FeedbackController extends ApiController
{
    public function store(Request $request)
    {
        $data = $request->only('content');
        $data['user_id'] = auth()->id() ?? null;

        event(new FeedbackedEvent(Feedback::create($data), auth()->id()));
        return $this->response()->noContent();
    }
}
