<?php

/*
 * add .styleci.yml
 */

namespace App\Repositories;

use App\Models\Comment;
use App\Events\CommentedEvent;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository
{
    protected $relation;

    /**
     * Specify Model class name.
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

        return $data;
    }

    public function created($data, $comment)
    {
        event(new CommentedEvent($comment, auth()->user()));
    }

    public function create(array $data)
    {
        if (method_exists($this, 'preCreate')) {
            $data = $this->preCreate($data);
        }
        $comment = $this->relation->comments()->create($data);
        if (method_exists($this, 'created')) {
            $this->created($data, $comment);
        }

        return $comment;
    }

    public function filterData(array &$data)
    {
        if (isset($data['content'])) {
            $data['content'] = e($data['content']);
        }

        return $data;
    }
}
