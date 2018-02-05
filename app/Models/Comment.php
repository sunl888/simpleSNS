<?php

/*
 * add .styleci.yml
 */

namespace App\Models;

use Ty666\LaravelVote\Traits\CanBeVoted;
use Ty666\LaravelVote\Traits\CanCountUpVotes;
use Ty666\LaravelVote\Contracts\CanCountUpVotesModel;

class Comment extends BaseModel implements CanCountUpVotesModel
{
    use CanBeVoted, CanCountUpVotes;

    protected $upVotesCountField = 'up_votes_count';

    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
