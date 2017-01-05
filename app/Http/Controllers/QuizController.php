<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Question;
use App\Course;

class QuizController extends Controller
{
  public function refresher()
  {

      $info = array();
      $info['name'] = '3 minute refresher';
      $info['main'] = 'Quiz with random questions from all your courses';
      $info['results'] = '<h5>Super-charge your learning?</h5><p>Share your Darwin course with friends and grow your question base together.
      <br>Sharing is caring folks!</p>';
      $info['level1'] = 'Fantastic!';
      $info['level2'] = 'Great!';
      $info['level3'] = 'You can improve!';
      $info['level4'] = 'Still need some work!';
      $info['level5'] = 'Gonna need some work buddy!';

      $questions = Auth::user()->questions()->orderByRaw("RAND()")->take(10)->get();
      $questionsArray = array();

      foreach($questions as $question){
        $singleQuestion = array();
        $singleQuestion['q'] = $question->question;
        $answersArray = array();

        foreach($question->answers()->orderByRaw("RAND()")->get() as $answer){
          $data =array();
          $data['option']  = $answer->answer;
          $data['correct']  = $answer->correct;
          array_push($answersArray, $data);
        }

        $singleQuestion['a'] = $answersArray;
        $singleQuestion['select_any'] = true;
        $singleQuestion['correct'] = 'Correct!';
        $singleQuestion['incorrect'] = 'Wrong!<br>The correct answer was: ' . $question->correctAnswer()->answer;
        array_push($questionsArray, $singleQuestion);
      }

      $response = array(
        'status' => 200,
        'info' => $info,
        'questions' => $questionsArray,
      );

      return response()->json($response);

  }

  public function course(Request $request)
  {

      $course = Course::find($request->course);

      $info = array();
      $info['name'] = $course->name;
      $info['main'] = 'Quiz with random questions from ' . $course->name;
      $info['results'] = '<h5>Super-charge your learning?</h5><p>Share your Darwin course with friends and grow your question base together.
      <br>Sharing is caring folks!</p>';
      $info['level1'] = 'Fantastic!';
      $info['level2'] = 'Great!';
      $info['level3'] = 'You can improve!';
      $info['level4'] = 'Still need some work!';
      $info['level5'] = 'Gonna need some work buddy!';

      $questions = $course->questions()->orderByRaw("RAND()")->get();
      $questionsArray = array();

      foreach($questions as $question){
        $singleQuestion = array();
        $singleQuestion['q'] = $question->question;
        $answersArray = array();

        foreach($question->answers()->orderByRaw("RAND()")->get() as $answer){
          $data =array();
          $data['option']  = $answer->answer;
          $data['correct']  = $answer->correct;
          array_push($answersArray, $data);
        }

        $singleQuestion['a'] = $answersArray;
        $singleQuestion['select_any'] = true;
        $singleQuestion['correct'] = 'Correct!';
        $singleQuestion['incorrect'] = 'Wrong!<br>The correct answer was: ' . $question->correctAnswer()->answer;
        array_push($questionsArray, $singleQuestion);
      }

      $response = array(
        'status' => 200,
        'info' => $info,
        'questions' => $questionsArray,
      );

      return response()->json($response);

  }
}
