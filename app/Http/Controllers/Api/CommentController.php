<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Controllers\ApiController;
use Ty666\LaravelVote\Contracts\VoteController;
use Ty666\LaravelVote\Traits\VoteControllerHelper;

class CommentController extends ApiController implements VoteController
{
    use VoteControllerHelper;

    protected $resourceClass = Comment::class;
}
