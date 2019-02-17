<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   $header   El estandar para una cabecera debe iniciar con X-
     * @return mixed
     */
    public function handle($request, Closure $next, $header = 'X-Name')
    {
        // De esta forma se construye la respuesta, debido a que se creara un encabezado personalizado
        $response = $next($request);

        $response->headers->set($header, config('app.name'));
        return $response;
    }
}
