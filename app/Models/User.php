<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use App\Transformers\ImageTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Ty666\LaravelVote\Traits\CanVote;

class User extends Authenticatable implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    // 通知 排序
    use Notifiable, Sortable;
    // 赞 关注 被关注 订阅
    use CanVote, CanFollow, CanBeFollowed, CanSubscribe;

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

    // 头像信息
    public function getAvatarHashAttribute($value)
    {
        return app(ImageTransformer::class)->transform(Image::find($value));
    }

    public function scopeApplyFilter($query, $data)
    {
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
