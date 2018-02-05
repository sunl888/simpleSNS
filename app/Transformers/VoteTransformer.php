<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use App\Models\Vote;

class VoteTransformer extends BaseTransformer
{
    public function transform(Vote $vote)
    {
        return [
            'type'       => $vote->type,
            'created_at' => toIso8601String($vote->created_at),
        ];
    }
}
