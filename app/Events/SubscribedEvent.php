<?php

/*
 * add .styleci.yml
 */

namespace App\Events;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class SubscribedEvent
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
        if ($this->model instanceof Collection) {
            // 接受通知的用户
            $this->to = $this->model->user;
            $this->message = [
                'message' => $this->from->username . '订阅了你的收藏集: ' . subtext($this->model->title, 8) . ' (＾▽＾)ｺ 快去看看吧',
            ];
        }
    }
}
