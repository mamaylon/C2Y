<?php

namespace C2Y\Http\Controllers;

use Socialite;
use C2Y\SocialAccountService;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
  private $fields = ['name', 'email', 'gender', 'birthday'];
  private $scopes = ['email', 'user_birthday'];

  public function redirect () {
    return Socialite::driver('facebook')
      ->fields($this->fields)
      ->scopes($this->scopes)
      ->redirect();
  }

  public function googleRedirect () {
    return Socialite::driver('google')
      ->scopes([
        'profile',
        'https://www.googleapis.com/auth/user.birthday.read'
      ])
      ->redirect();
  }

  public function callback (SocialAccountService $service) {
    $provider = Socialite::driver('facebook')
      ->fields($this->fields)
      ->user();
    $user = $service->createOrGetUser($provider, 'facebook');
    auth()->login($user);
    return redirect()->to('/');
  }

  public function googleCallback (SocialAccountService $service) {
    $provider = Socialite::driver('google')->user();
    $provider->birthday = null;
    $user = $service->createOrGetUser($provider, 'google');
    auth()->login($user);
    return redirect()->to('/');
  }
}
