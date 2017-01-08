<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use Auth;
use Jenssegers\Agent\Agent;

class CourseController extends Controller
{
    public function index()
    {
        return view('course');
    }

    public function single($user, $course)
    {
        $course = User::find($user)->courses()->find($course);

        $agent = new Agent();

        if($agent->isMobile()){
          return view('mobile.course', compact('course'));
        } else {
            return view('course', compact('course'));
        }

    }

    public function remove(Request $request)
    {
        Auth::user()->courses()->detach($request->course);
        return response()->json(['course' => Course::find($request->course)], 200);
    }
}
