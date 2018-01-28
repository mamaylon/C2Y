<?php

namespace C2Y\Http\Controllers;

use Socialite;
use C2Y\SocialAccountService;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
  public function redirect () {
    return Socialite::driver('facebook')->redirect();
  }

  public function googleRedirect () {
    return Socialite::driver('google')->redirect();
  }

  public function callback (SocialAccountService $service) {
    $provider = Socialite::driver('facebook')->user();
    $user = $service->createOrGetUser($provider, 'facebook');
    auth()->login($user);
    return redirect()->to('/');
  }
  
  public function googleCallback (SocialAccountService $service) {
    $provider = Socialite::driver('google')->user();
    $user = $service->createOrGetUser($provider, 'google');
    auth()->login($user);
    return redirect()->to('/');
  }
}
