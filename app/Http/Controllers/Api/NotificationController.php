<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Transformers\NotificationTransformer;
use Carbon\Carbon;

class NotificationController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 获取未读消息的数量.
     * @return array
     */
    public function showUnreadNotificationsCount()
    {
        return [
            'unread' => auth()->user()->unreadNotifications()->count(),
        ];
    }

    /**
     * 获取消息通知.
     * @return array
     */
    public function getNotifications()
    {
        return $this->response()->collection(auth()->user()->notifications, new NotificationTransformer());
    }

    /**
     * 将消息通知标记为已读.
     * @return array
     */
    public function markAsRead($id = null)
    {
        // 如果 id 为 null，表示将全部消息标记为已读
        $notifications = auth()->user()->unreadNotifications();

        if (null != $id) {
            $notifications->where('id', $id);
        }

        $notifications->update(['read_at' => Carbon::now()]);

        return $this->response()->noContent();
    }
}
