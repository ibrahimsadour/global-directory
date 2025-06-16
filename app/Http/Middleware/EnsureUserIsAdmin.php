<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
public function handle(Request $request, Closure $next): Response
{
    // إذا المستخدم غير مسجل دخول
    if (!auth()->check()) {
        return redirect('/')->with('error', 'يرجى تسجيل الدخول أولاً.');
    }

    // إذا المستخدم ليس admin
    if (auth()->user()->role !== 'admin') {
        auth()->logout();
        return redirect('/')->with('error', 'غير مصرح لك بالدخول إلى لوحة التحكم.');
    }

    // إذا المستخدم admin، اسمح له بالمتابعة
    return $next($request);
}

}
