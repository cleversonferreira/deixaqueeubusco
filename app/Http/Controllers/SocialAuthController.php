<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAuthService;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAuthService $service)
    {
        try {
            $user = $service->getSocialUser(Socialite::driver('facebook')->user());
            auth()->login($user);
        } catch (Exception $exception) {}

        return redirect()->to('/home');
    }
}
