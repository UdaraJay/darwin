<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $fillable = [
    'name', 'course_id', 'created_by', 'description', 'published',  'question_count'
  ];

  protected $dates = ['created_at', 'updated_at'];

  public function users()
  {
      return $this->belongsToMany('App\User', 'user_topic_relations', 'user_id', 'topic_id');
  }

  public function questions()
  {
    return $this->hasMany('App\Question', 'topic_id');
  }
}
