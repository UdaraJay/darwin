<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $fillable = [
    'question', 'course_id', 'topic_id', 'user_id', 'question_explanation', 'published',  'challenged'
  ];

  protected $dates = ['created_at', 'updated_at'];

  public function answers()
  {
    return $this->hasMany('App\Answer', 'question_id');
  }

  public function correctAnswer()
  {
    return $this->hasMany('App\Answer', 'question_id')->where('correct', 1)->first();
  }

  public function course()
  {
      return $this->belongsTo('App\Course');
  }
}
