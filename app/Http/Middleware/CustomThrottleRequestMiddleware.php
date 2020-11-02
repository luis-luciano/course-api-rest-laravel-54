<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleRequestMiddleware extends ThrottleRequests
{
    use ApiResponser;

    /**
     * Create a 'too many attempts' response.
     * Para continuar con la estructura de respuesta general se extiende del Middleware original
     * Sobrescribiendo el metodo buildResponse
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildResponse($key, $maxAttempts)
    {
        $response = $this->errorResponse(Response::$statusTexts[Response::HTTP_TOO_MANY_REQUESTS], Response::HTTP_TOO_MANY_REQUESTS);

        $retryAfter = $this->limiter->availableIn($key);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
