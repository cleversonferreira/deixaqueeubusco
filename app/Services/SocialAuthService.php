<?php

namespace App\Services;

use App\User;
use App\SocialLogin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

        $user = $this->getOrCreateUser($providerUser);
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

    /**
     * @param ProviderUser $providerUser
     * @return User|Builder|Model|object|null
     */
    private function getOrCreateUser(ProviderUser $providerUser)
    {
        $user = $this->getUserByEmail($providerUser->getEmail());
        if ($user) return $user;

        return $this->createUser($providerUser);
    }

    /**
     * @param $email
     * @return Builder|Model|object|null
     */
    private function getUserByEmail($email)
    {
        if (empty($email)) return null;

        return User::query()
            ->where('email', $email)
            ->first();
    }

    /**
     * @param ProviderUser $providerUser
     * @return Builder|Model
     */
    private function createUser(ProviderUser $providerUser)
    {
        $email = $providerUser->getEmail() ?: $providerUser->getId() . '@facebook.com';
        $name = $providerUser->getName() ?: 'Voluntário';
        $password = md5(rand(1, 9999));

        return User::query()
            ->create([
                'email' => $email,
                'name' => $name,
                'password' => $password,
            ]);
    }
}
