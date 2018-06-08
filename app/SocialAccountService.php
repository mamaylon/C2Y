<?php
namespace C2Y;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {

  public function createOrUpdate ($data) {
    if (!$data['birthday']) {
      unset($data['birthday']);
    }
    $user = User::whereEmail($data['email'])->first();
    if (!$user) {
      return User::create($data);
    }
    if ($user->photo !== $data['photo']) {
      $user->photo = $data['photo'];
      $user->save();
    }
    return $user;
  }

  public function createOrGetUser (ProviderUser $providerUser, $provider) 
  {

    $account = SocialAccount::show($provider, $providerUser->getId());

    if ($account) 
    {
      return $account->user;
    }

    $account = new SocialAccount([
      'provider_user_id' => $providerUser->getId(),
      'provider' => $provider
    ]);
    $user = $this->createOrUpdate([
      'email' => $providerUser->getEmail(),
      'name' => $providerUser->getName(),
      'photo' => $providerUser->avatar_original,
      'birthday' => isset($providerUser->user['birthday'])
        ? $providerUser->user['birthday']
        : null
    ]);

    $account->user()->associate($user);
    $account->save();

    return $user;
  }
}