<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useFallbackUrl(config('app.placeholder') . '160.png')
            ->useFallbackPath(config('app.placeholder') . '160.png')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(160)
                    ->height(160);
            });

            $this->addMediaCollection('signature')
            ->singleFile()
            ->useFallbackUrl(config('app.placeholder') . '160.png')
            ->useFallbackPath(config('app.placeholder') . '160.png')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb1')
                    ->width(260)
                    ->height(260);
            });
    }

    /**
     * Get all users
     *
     * @return mixed
     */
    public static function getAllUsers()
    {
        return Cache::rememberForever('users.all', function () {
            return self::with('role')->latest('id')->get();
        });
    }

    /**
     * Check if user is admin or not.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role->slug === 'central-admin' || $this->role->slug === 'director-general';
    }

    /**
     * Check if user has the given role.
     *
     * @param $slug
     * @return bool
     */
    public function hasRole($slug): bool
    {
        return $this->role->slug === $slug;
    }

    /**
     * Check if user has given permission.
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        return $this->role->permissions()->where('slug', $permission)->first() ? true : false;
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('users.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }

    /**
     * User belongsTo a role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * questions
     *
     * @return void
     */
    public function questions(){
        return $this->hasMany(Forum::class);
    }

    /**
     * replies
     *
     * @return void
     */
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckStation($query)
    {
        return $query->where('station_id',Auth::user()->station->id);
    }
}


