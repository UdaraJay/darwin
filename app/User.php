<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\SocialAccount;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function facebook()
    {
      return $this->hasOne('App\SocialAccount')->where('provider', 'facebook');
    }

    public function questions()
    {
      return $this->hasMany('App\Question', 'user_id');
    }

    public function scores()
    {
      return $this->hasMany('App\Score', 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'user_course_relations', 'user_id', 'course_id')->orderBy('updated_at', 'desc');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic', 'user_topic_relations', 'user_id', 'topic_id')->orderBy('updated_at', 'desc');
    }
}
