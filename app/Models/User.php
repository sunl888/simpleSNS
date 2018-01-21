<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'nickname', 'tel_num', 'avatar', 'email', 'password', 'introduction',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 关注我的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follows()
    {
        return $this->belongsTo(Follow::class, 'user_id', 'id');
    }

    /**
     * 我赞过的文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
