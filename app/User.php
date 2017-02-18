<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'birthday',
        'location', 'contact', 'about', 'gender', 'status', 'api_token', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Additional query scope, select published article only.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActivated($query)
    {
        return $query->where('users.status', 'activated');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function screenshots()
    {
        return $this->hasManyThrough(Screenshot::class, Portfolio::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function members()
    {
        return $this->select('id', 'name', 'username', 'email', 'avatar', 'status')
            ->whereHas('roles', function ($query) {
                $query->where('role', 'member');
            })
            ->paginate(10);
    }
}
