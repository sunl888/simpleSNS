<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

class NotificationTransformer extends BaseTransformer
{
    public function transform($notification)
    {
        return [
            'id'         => $notification->id,
            'type'       => snake_case(class_basename($notification->type)),
            'data'       => $notification->data,
            'read_at'    => toIso8601String($notification->read_at),
            'created_at' => toIso8601String($notification->created_at),
        ];
    }
}
