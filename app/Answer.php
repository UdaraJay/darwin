<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  protected $fillable = [
    'answer', 'correct', 'course_id', 'topic_id', 'question_id', 'user_id', 'answer_explanation', 'published',  'challenged'
  ];

  protected $dates = ['created_at', 'updated_at'];
}
