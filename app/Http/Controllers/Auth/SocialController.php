<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    // Google
    public function redirectGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callbackGoogle(Request $request)
    {
        try {
            $socialUser = Socialite::driver('google')->stateless()->user();
            return $this->handleSocialUser($socialUser, 'google', $request);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول عبر Google.');
        }
    }

    // Twitter
    public function redirectTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function callbackTwitter(Request $request)
    {
        try {
            $socialUser = Socialite::driver('twitter')->user();
            return $this->handleSocialUser($socialUser, 'twitter', $request);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول عبر Twitter.');
        }
    }

    // Facebook
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function callbackFacebook(Request $request)
    {
        try {
            $socialUser = Socialite::driver('facebook')->stateless()->user();
            return $this->handleSocialUser($socialUser, 'facebook', $request);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول عبر Facebook.');
        }
    }

    private function handleSocialUser($socialUser, $provider, $request)
    {
        $email = $socialUser->getEmail();

        if (!$email) {
            $email = $socialUser->getId() . "@{$provider}.local"; // مثال: 123456@facebook.local
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name'           => $socialUser->getName() ?? $socialUser->getNickname() ?? 'مستخدم جديد',
                'email'          => $email,
                'password'       => bcrypt(Str::random(16)),
                "{$provider}_id" => $socialUser->getId(),
                'provider'       => $provider,
                'profile_photo'  => $socialUser->getAvatar(),
                'signup_ip'      => $request->ip(),
                'is_verified'    => true,
            ]);
        } else {
            $user->update([
                "{$provider}_id" => $user["{$provider}_id"] ?? $socialUser->getId(),
                'provider'       => $user->provider ?? $provider,
            ]);
        }

        $user->last_login_at = now();
        $user->save();

        Auth::login($user, true);
        return redirect()->route('user.dashboard');
    }



}
