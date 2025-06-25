<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsRegular
{
    public function handle(Request $request, Closure $next): Response
    {
        // إن لم يكن مسجلاً
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً.');
        }

        // إن كان Admin
        if (auth()->user()->role === 'admin') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'غير مصرح لك بالدخول إلى لوحة المستخدم.',
            ]);
        }

        return $next($request);
    }
}
