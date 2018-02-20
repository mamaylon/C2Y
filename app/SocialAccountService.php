<?php
namespace C2Y;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {

  public function createOrGetUser (ProviderUser $providerUser, $provider) {

    $account = SocialAccount::show($provider, $providerUser->getId());
    if ($account) {
      return $account->user;
    }

    $account = new SocialAccount([
      'provider_user_id' => $providerUser->getId(),
      'provider' => $provider
    ]);

    $user = User::whereEmail($providerUser->getEmail())->first();

    if (!$user) {
      $user = User::create([
        'email' => $providerUser->getEmail(),
        'name' => $providerUser->getName(),
        'photo' => $providerUser->avatar_original
      ]);
    }

    $account->user()->associate($user);
    $account->save();

    return $user;
  }
}