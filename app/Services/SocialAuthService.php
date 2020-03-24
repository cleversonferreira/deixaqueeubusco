<?php

namespace App\Services;

use App\User;
use App\SocialLogin;
use InvalidArgumentException;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAuthService
{
    public function getSocialUser(ProviderUser $providerUser)
    {
        $user = $this->getUserFromSocialAccount($providerUser);
        if ($user) return $user;

        $account = new SocialLogin([
            'provider_user_id' => $providerUser->getId(),
            'provider' => 'facebook'
        ]);

        if (empty($providerUser->getEmail())) {
            throw new InvalidArgumentException('Não foi possível detectar o e-mail');
        }

        $user = User::whereEmail($providerUser->getEmail())->first();

        if (!$user) {

            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'password' => md5(rand(1, 9999)),
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }

    private function getUserFromSocialAccount(ProviderUser $providerUser)
    {
        $account = SocialLogin::query()
            ->where('provider_user_id', $providerUser->getId())
            ->where('provider', 'facebook')
            ->with('user')
            ->first();

        if (is_null($account)) return null;

        return $account->user;
    }
}
