<?php

namespace App\Models;

class PostContent extends BaseModel
{
    public $incrementing = false;
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    protected $fillable = ['content'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
