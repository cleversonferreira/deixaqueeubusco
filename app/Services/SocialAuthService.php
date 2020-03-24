<?php

namespace App\Services;

use App\User;
use App\SocialLogin;
use InvalidArgumentException;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAuthService
{
    /**
     * @param ProviderUser $providerUser
     * @return User|Builder|Model|object|null
     */
    public function getSocialUser(ProviderUser $providerUser)
    {
        $user = $this->getUserFromSocialAccount($providerUser);
        if ($user) return $user;

        $user = User::whereEmail($providerUser->getEmail())->first();

        if (!$user) {

            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'password' => md5(rand(1, 9999)),
            ]);
        }

        $this->createSocialAccount($providerUser, $user);

        return $user;
    }

    /**
     * @param ProviderUser $providerUser
     * @return User|null
     */
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

    /**
     * @param ProviderUser $providerUser
     * @param User $user
     */
    private function createSocialAccount($providerUser, $user)
    {
        $account = new SocialLogin([
            'provider_user_id' => $providerUser->getId(),
            'provider' => 'facebook'
        ]);
        $account->user()->associate($user);
        $account->save();
    }
}
