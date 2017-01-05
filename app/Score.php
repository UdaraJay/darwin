<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
  protected $fillable = [
    'score', 'course_id', 'topic_id', 'user_id',
  ];

  protected $dates = ['created_at', 'updated_at'];
}
