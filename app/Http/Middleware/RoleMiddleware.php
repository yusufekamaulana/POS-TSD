<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check user role
        if ($role === 'admin' && $user->role !== 'admin') {
            return back()->withErrors(['access' => 'Access denied. Admins only.']);
        }

        if ($role === 'karyawan' && $user->role !== 'karyawan') {
            return back()->withErrors(['access' => 'Access denied. Employees only.']);
        }

        return $next($request);
    }
}
