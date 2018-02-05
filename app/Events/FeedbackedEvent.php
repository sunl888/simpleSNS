<?php

/*
 * add .styleci.yml
 */

namespace App\Events;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class FeedbackedEvent
{
    use SerializesModels;

    public $model;
    public $from;
    public $to;
    public $message;

    public function __construct(Model $model, User $from)
    {
        $this->model = $model;
        $this->from = $from;

        $this->handle();
    }

    public function handle()
    {
        if ($this->model instanceof Feedback) {
            // 接受通知的用户
            $this->to = User::find(1);
            $this->message = [
                'message' => $this->from->username . '给你发了一条反馈 (＾▽＾)ｺ 快去看看吧',
            ];
        }
    }
}
