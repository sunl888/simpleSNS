<?php

/*
 * add .styleci.yml
 */

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class FollowedEvent
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
        if ($this->model instanceof User) {
            // 接受通知的用户
            $this->to = $this->model;
            $this->message = [
                'message' => $this->from->username . '关注了你 (＾▽＾)ｺ 快去看看吧',
            ];
        }
    }
}
