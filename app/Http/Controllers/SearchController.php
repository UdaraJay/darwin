<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Topic;
use Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function courses(Request $request)
    {
        $results = Course::where('name', 'LIKE', '%'. $request['query'] .'%')
        ->where('created_by', Auth::user()->id)
        ->get();
        $response = array(
          'status' => 200,
          'courses' => $results
        );

        return response()->json($response);
    }

    public function createCourse(Request $request){
        if(!Course::where('name', $request->name)
        ->where('created_by', Auth::user()->id)
        ->exists()){
          $course = Auth::user()->courses()->create([
              'name' => $request->name,
              'created_by' => Auth::user()->id,
          ]);
        } else {
            $course = Course::where('name', $request->name)->first();
        }

        return response()->json(['course' => $course], 200);
    }

    public function createCourseByID(Request $request){
      if(!Auth::user()->courses->contains($request->id)){
        Auth::user()->courses()->attach($request->id);
      }

      $course = Course::find($request->id);

      return response()->json(['course' => $course], 200);
    }

    public function topics(Request $request)
    {
        // $results = Course::where('name', 'LIKE', '%'. $request['query'] .'%')->get();
        $response = array(
          'status' => 200,
          'topics' => Topic::where('created_by', Auth::user()->id)->get(),
        );

        return response()->json($response);
    }

    public function createTopic(Request $request){
        if(!Topic::where('name', $request->name)->where('created_by', Auth::user()->id)->exists()){
          $topic = Auth::user()->topics()->create([
              'name' => $request->name,
              'created_by' => Auth::user()->id,
              'course_id' => $request->course,
          ]);
        }

        return response()->json(['topic' => $topic], 200);
    }
}
