<?php

namespace App\Models;

class PostContent extends BaseModel
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    public $incrementing = false;

    protected $fillable = ['content'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
