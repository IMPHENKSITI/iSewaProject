<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store the intended URL so we can redirect back after login
            return redirect()->route('beranda')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman admin.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            // User is logged in but not an admin
            return redirect()->route('beranda')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // User is authenticated and is an admin, proceed
        return $next($request);
    }
}
