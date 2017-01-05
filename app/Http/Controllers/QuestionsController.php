<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use Auth;


class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {

      $this->validate($request, [
        'question' => 'required',
        'correct_answer' => 'required',
        'wrong_answers' => 'required',
        'topic' => 'required',
        'course' => 'required',
      ]);

        $question = Auth::user()->questions()->create([
            'question' => $request->question,
            'course_id' => $request->course,
            'topic_id' => $request->topic,
        ]);

        //correct answer
        $question->answers()->create([
            'answer' => $request->correct_answer,
            'correct' => true,
            'user_id' => Auth::user()->id,
            'topic_id' => $request->topic,
            'course_id' => $request->course,
        ]);

        //wrong answers
        foreach($request->wrong_answers as $wrong_answer){
          $question->answers()->create([
              'answer' => $wrong_answer,
              'correct' => false,
              'user_id' => Auth::user()->id,
              'topic_id' => $request->topic,
              'course_id' => $request->course,
          ]);
        }

        if(!Auth::user()->courses->contains($request->course)){
          Auth::user()->courses()->attach($request->course);
        }

        if(!Auth::user()->topics->contains($request->topic)){
          Auth::user()->topics()->attach($request->topic);
        }

        return response()->json(['course' => $question->course->name], 200);
    }
}
