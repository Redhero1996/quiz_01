<?php

namespace App;

use App\Models\Comment;
use App\Models\Role;
use App\Models\Topic;
use App\Models\Like;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'role_id',
        'avatar',
        'email',
        'password',
        'provider_id',
        'provider',
        'access_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withPivot([
            'id',
            'answered',
            'total',
        ])->orderBy('total', 'desc')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
