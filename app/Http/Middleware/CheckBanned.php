<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            Auth::logout(); // Разлогиниваем пользователя

            return redirect()->route('login')->withErrors([
                'email' => 'Ваш аккаунт заблокирован. Обратитесь к администратору.',
            ]);
        }

        return $next($request);
}
}
