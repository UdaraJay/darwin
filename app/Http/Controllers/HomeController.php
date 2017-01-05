<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SocialAccount;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $agent = new Agent();
        if($agent->isMobile()){
          return view('mobile.home');
        } else {
          return view('home');
        }

    }

    public function facebookFriends()
    {

      $friends = collect();

      try {
        if($this->facebook->token != ''){
          $graphUrl = 'https://graph.facebook.com';
          $version = 'v2.8';
          $token = $this->facebook->token;

          $meUrl = $graphUrl.'/'.$version.'/me/friends/?access_token='.$token;

          $json = file_get_contents($meUrl);
          $obj = json_decode($json);


          foreach($obj->data as $friend){
              if(SocialAccount::where('provider_user_id', $friend->id)->exists()){
                $friends->push(SocialAccount::where('provider_user_id', $friend->id)->first()->user);
              }
          }
        }
      }
      catch (\Exception $e) {
        return $friends;
      }

      return $friends;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


}
