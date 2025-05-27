<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserBan
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', '⛔ Ваш аккаунт был заблокирован администратором. Доступ к системе запрещен. Для разблокировки обратитесь к администрации.');
        }

        return $next($request);
    }
} 