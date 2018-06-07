<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
	use Traits\HasCompositePrimaryKey;
	protected $primaryKey = ['user_id', 'provider_user_id', 'provider'];
	protected $fillable = ['user_id', 'provider_user_id', 'provider'];

	public function user () {
		return $this->belongsTo(User::class);
	}

	public static function show ($provider, $providerId) {
		return self::whereProvider($provider)
      ->whereProviderUserId($providerId)
      ->with('user')
      ->first();
	}
}
