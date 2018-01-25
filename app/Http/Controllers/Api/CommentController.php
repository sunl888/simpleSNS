<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Comment;
use Ty666\LaravelVote\Contracts\VoteController;
use Ty666\LaravelVote\Traits\VoteControllerHelper;

class CommentController extends ApiController implements VoteController
{
    use VoteControllerHelper;

    protected $resourceClass = Comment::class;

}
