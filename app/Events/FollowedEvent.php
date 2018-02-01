<?php

namespace App\Events;

use App\Models\Collection;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class FollowedEvent
{
    use SerializesModels;

    public $follow;
    public $from;
    public $to;
    public $message;

    public function __construct(Follow $follow, User $from)
    {
        $this->follow = $follow;
        $this->from = $from;

        $this->handle();
    }

    public function handle()
    {
        if ($this->follow->follow_type == Collection::class) {
            // 接受通知的用户
            $collection = Collection::findOrFail($this->follow->follow_id);
            $this->to = $collection->user;
            $this->message = [
                'message' => $this->from->username . '关注了你的收藏集: ' . $collection->title
            ];
        } else {
            $this->to = User::findOrFail($this->follow->follow_id);
            $this->message = [
                'message' => $this->from->username . '关注了你'
            ];
        }
    }
}
