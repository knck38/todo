<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //セッションにuser_idが存在しない場合、生成して保存する
        if (!session()->has('user_id')) {
            //ユニークなIDをセッションに保存
            session(['user_id' => uniqid('user_', true)]);
        }
        
        return $next($request);
    }
}
