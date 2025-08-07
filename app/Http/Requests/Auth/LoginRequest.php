<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    $login = $this->input('login');
    $password = $this->input('password');

    // تحديد نوع الحقل: بريد أو رقم هاتف
    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    // محاولة جلب المستخدم بناءً على البريد أو الهاتف
    $user = \App\Models\User::where($fieldType, $login)->first();

    // التحقق من وجود المستخدم وكلمة المرور
    if (! $user || ! \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.failed'), // نص الخطأ في ملف lang/ar/auth.php
        ]);
    }

    // التحقق من حالة الحساب (مفعل أو لا)
    if ($user->status != 1) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'تم تعطيل حسابك من قبل الإدارة.',
        ]);
    }

    // تسجيل الدخول بنجاح
    Auth::login($user, $this->boolean('remember'));

    RateLimiter::clear($this->throttleKey());
}



    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('login')) . '|' . $this->ip();
    }
}
