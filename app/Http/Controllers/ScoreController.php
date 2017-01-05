<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Auth;

class ScoreController extends Controller
{
  public function record(Request $request){
      $score = Auth::user()->scores()->create([
          'score' => $request->score,
          'course_id' => $request->course,
          'topic_id' => $request->topic,
      ]);

      return response()->json(null, 200);
  }
}
