<?php

namespace App\Events;

use App\Models\Collection;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Followed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $follow;
    public $user;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
        if ($follow->follow_type == Collection::class) {
            // 接受通知的用户
            $collection = Collection::findOrFail($follow->follow_id);
            $user = $collection->user;
            $this->message = [
                'message' => auth()->user()->username . '关注了你的收藏集: ' . $collection->title
            ];
        } else {
            $user = User::find($follow->follow_id);
            $this->message = [
                'message' => auth()->user()->username . '关注了你'
            ];
        }
        $this->user = $user;
    }

    public function broadcastOn()
    {
        //要发送的频道
        return ['USER_ID' . $this->user->id];
    }

    public function broadcastWith()
    {
        //发送的数据
        return $this->message;
    }
}
