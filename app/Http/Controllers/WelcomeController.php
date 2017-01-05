<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Jenssegers\Agent\Agent;

class WelcomeController extends Controller
{
  public function index()
  {
      if(Auth::check()){
        return redirect('/home');
      }

      $user_count = User::count() + 212;

      $agent = new Agent();
      if($agent->isDesktop()){
        return view('landing', compact('user_count'));
      } else {
        return view('mobile.landing', compact('user_count'));
      }
  }

  public function privacy()
  {
      return view('privacy');
  }
}
