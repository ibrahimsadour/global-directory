<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'           => $socialUser->getName() ?? $socialUser->getNickname() ?? 'مستخدم جديد',
                'email'          => $socialUser->getEmail(),
                'password'       => bcrypt(Str::random(16)), // كلمة مرور عشوائية
                'role'           => 'user',
                'phone'          => null,
                'profile_photo'  => $socialUser->getAvatar(), // لو متوفر صورة من جوجل/فيسبوك
                'bio'            => null,

                "{$provider}_id" => $socialUser->getId(),
                'provider'       => $provider,
                'last_login_at'  => now(),
                'signup_ip'      => request()->ip(),
                'is_verified'    => true,
                'status'         => true,
                'remember_token' => Str::random(60),
            ]);
        } else {
            // تحديث بيانات الدخول فقط
            $user->update([
                "{$provider}_id" => $user->getAttribute("{$provider}_id") ?? $socialUser->getId(),
                'last_login_at'  => now(),
                'provider'       => $provider,
            ]);
        }

        Auth::login($user, true);
        return redirect()->route('user.dashboard');
    }


}
