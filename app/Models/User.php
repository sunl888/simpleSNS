<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ty666\LaravelVote\Traits\CanVote;

class User extends Authenticatable implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    use Notifiable, CanVote, Sortable;

    protected $fillable = [
        'nickname',
        'tel_num',
        'avatar_hash',
        'email',
        'password',
        'introduction',
        'is_banned',
        'city',
        'oauth_token',
        'location',
        'company',
        'username',
        'name',
        'provider',
        'last_actived_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['last_active_at'];

    public function scopeApplyFilter($query, $data)
    {
        //$data = $data->only('');
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
     * @param array $primarys
     * @param array $credentials 0=>'username', 1=>'password', 2=>'provider'
     * @return Builder
     */
    public function scopeByUserNames($query, array $primarys, array $credentials): Builder
    {
        list($username, , $provider) = array_values($credentials);

        return tap($query->Provider($provider), function ($query) use ($primarys, $username) {
            $query->where(function ($query) use ($primarys, $username) {
                foreach ($primarys as $primary) {
                    $query->orWhere([$primary => $username]);
                }
            });
        });
    }

    public function scopeProviderWithNull($query)
    {
        return $query->whereNull('provider');
    }

    public function scopeProvider($query, $provider)
    {
        return $query->whereProvider($provider);
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
