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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function HasComment()
    {
        return $this->hasMany('App\Comments', 'ChildCommentOfUser');
    }
    public function HasLike()
    {
        return $this->hasMany('App\Comments', 'ChildLikeOfUser');
    }
    public function HasDisLike()
    {
        return $this->hasMany('App\Comments', 'ChildDisLikeOfUser');
    }
}
