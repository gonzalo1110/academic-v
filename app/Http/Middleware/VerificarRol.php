<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarRol
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->rol, $roles)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
