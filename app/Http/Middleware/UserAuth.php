<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('user_id') && $request->session()->get('user_role') == 'user') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Please login to access user panel');
    }
}
