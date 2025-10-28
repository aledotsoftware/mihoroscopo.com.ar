<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateCardToken
{
    public function handle(Request $request, Closure $next)
    {
        // Validación básica para el token de la tarjeta
        if (!$request->has('card_token_id') || empty($request->input('card_token_id'))) {
            return response()->json(['error' => 'Card token is required'], 400);
        }

        return $next($request);
    }
}
