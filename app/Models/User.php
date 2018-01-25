<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'nickname', 'tel_num', 'avatar_hash', 'email', 'password', 'introduction', 'is_banned', 'city', 'oauth_token', 'location', 'company', 'username', 'name', 'provider', 'last_actived_at',
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

    public function avatar()
    {
        return $this->hasOne(Image::class, 'hash', 'avatar_hash');
    }

    /**
     * @param $query
     * @param $primacy 's
     * @param $credentials 0=>'username', 1=>'password', 2=>'provider'
     * @return mixed
     */
    public function scopeByPrimaryKeys($query, $primarys, $credentials)
    {
        list($username, , $provider) = array_values($credentials);

        $query->where(['provider' => $provider]);
        $query->where(function ($query) use ($primarys, $username) {
            foreach ($primarys as $primary) {
                $query->orWhere([$primary => $username]);
            }
            return $query;
        });

        return $query;
    }

    public function scopeProviderWithNull($query)
    {
        return $query->where('provider', null);
    }

}
