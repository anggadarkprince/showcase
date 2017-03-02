<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;

    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'birthday', 'location',
        'contact', 'about', 'gender', 'status', 'token', 'api_token', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['birthday', 'created_at', 'updated_at'];

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
            //->whereHas('roles', function ($query) {
            //    $query->where('role', 'member');
            //})
            ->latest()
            ->paginate(10);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'about' => $this->about,
            'status' => $this->status,
        ];
    }

    public function searchManual($query)
    {
        return $this->where('username', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('about', 'like', "%{$query}%")
            ->paginate(12);
    }
}
