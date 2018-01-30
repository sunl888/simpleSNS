<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ty666\LaravelVote\Traits\CanVote;

class User extends Authenticatable implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    use Notifiable, CanVote, Sortable;

    protected $fillable = [
        'nickname', 'tel_num', 'avatar_hash', 'email', 'password', 'introduction', 'is_banned', 'city', 'oauth_token', 'location', 'company', 'username', 'name', 'provider', 'last_actived_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['last_active_at'];

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('');
        // todo 这里过滤
        return $query->ordered()->recent();
    }

    public function avatar()
    {
        return $this->hasOne(Image::class, 'hash', 'avatar_hash');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 获得此用户的所有关注者。
     */
    public function followUsers()
    {
        return $this->hasMany(Follow::class, 'user_id')->byType('App\Models\User');
    }

    public function followCollections()
    {
        return $this->hasMany(Follow::class, 'user_id')->byType('App\Models\Collection');
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
