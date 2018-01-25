<?php

namespace App\Repositories;

use App\Events\Commented;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository
{
    protected $relation;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    public function createComment(Model $relation, array $data)
    {
        $this->relation = $relation;
        return $this->create($data);
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);

        $data['user_id'] = auth()->id();
        $comment = $this->relation->comments()->create($data);
        $comment->up_votes_count = 0;
        event(new Commented($comment, $this->relation, auth()->user()));
        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['content']))
            $data['content'] = e($data['content']);

        return $data;
    }

}
