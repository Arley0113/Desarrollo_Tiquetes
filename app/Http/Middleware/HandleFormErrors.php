<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleFormErrors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Si hay errores de validación, logearlos para debugging
        if ($response->getStatusCode() === 422) {
            $errors = $request->session()->get('errors');
            if ($errors) {
                Log::warning('Errores de validación en formulario', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'errors' => $errors->getMessages(),
                    'user_id' => auth()->id()
                ]);
            }
        }

        return $response;
    }
}
