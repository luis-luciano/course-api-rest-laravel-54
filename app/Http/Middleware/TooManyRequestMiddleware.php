<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class TooManyRequestMiddleware
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() === Response::HTTP_TOO_MANY_REQUESTS) {
            return $response = $this->errorResponse(
                Response::$statusTexts[Response::HTTP_TOO_MANY_REQUESTS],
                Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        return $response;
    }
}
