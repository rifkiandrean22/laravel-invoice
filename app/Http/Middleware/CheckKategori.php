<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckKategori
{
    public function handle(Request $request, Closure $next, $kategori)
    {
        if (!Auth::check() || Auth::user()->kategori !== $kategori) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
