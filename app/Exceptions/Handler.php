<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // custom rendering for the purpose of developing api rest and response json

        // if debug is true response with html
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        $exception = $this->prepareException($exception);

        if ($this->isValidationException($exception) && $request->wantsJson()) {
            return $this->errorResponse(
                $exception->validator->errors()->getMessages(), Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($this->isHttpException($exception)) {
            return $this->errorResponse(
                Response::$statusTexts[$exception->getStatusCode()], $exception->getStatusCode()
            );
        }

        if ($this->isAuthenticationException($exception)) {
            return $this->unauthenticated();
        }

        if ($this->isQueryException($exception)) {
            $errorQueryCode = $exception->errorInfo[1];

            // Cannot delete or update a parent row: a foreign key constraint fails (MySQL or MariaDB)
            if ($errorQueryCode == 1451) {
                return $this->errorResponse('Error de operación por recurso relacionado', Response::HTTP_CONFLICT);
            }
        }

        return $this->errorResponse('Unexpected server error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // if ($request->expectsJson()) {
        //     return response()->json(['error' => 'Unauthenticated.'], 401);
        // }

        // return redirect()->guest(route('login'));

        // purpose, response json
        return $this->errorResponse('Unauthenticated', 401);
    }

    // methods custom luis luciano

    /**
     * Determine if the given exception is an validation exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isValidationException(Exception $e)
    {
        return $e instanceof ValidationException;
    }

    protected function isAuthenticationException(Exception $e)
    {
        return $e instanceof AuthenticationException;
    }

    protected function isQueryException(Exception $e)
    {
        return $e instanceof QueryException;
    }
}
