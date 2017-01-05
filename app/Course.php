<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $fillable = [
    'name', 'created_by', 'subscriber_count', 'description', 'published'
  ];

  protected $dates = ['created_at', 'updated_at'];

  public function users()
  {
      return $this->belongsToMany('App\User', 'user_course_relations', 'user_id', 'course_id');
  }

  public function owner()
  {
      return $this->hasOne('App\User', 'created_by');
  }

  public function topics()
  {
    return $this->hasMany('App\Topic', 'course_id');
  }

  public function questions()
  {
    return $this->hasMany('App\Question', 'course_id');
  }


}
