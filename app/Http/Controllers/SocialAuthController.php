<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Auth;

class SocialAuthController extends Controller
{
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }

  public function callback(SocialAccountService $service)
  {
    $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
    auth()->login($user);
    return redirect()->to('/home');
  }
}
