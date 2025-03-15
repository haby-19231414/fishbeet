<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        foreach ($roles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                return $next($request);
            }
            
            if ($role === 'pedagang' && $user->isPedagang()) {
                return $next($request);
            }
            
            if ($role === 'user' && $user->role === 'user') {
                return $next($request);
            }
        }
        
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
} 