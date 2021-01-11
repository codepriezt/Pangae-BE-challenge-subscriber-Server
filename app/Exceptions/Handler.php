<?php

namespace App\Exceptions;



use Throwable;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
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
    public function render($request, Throwable $exception)
    {
        // dd($exception);
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->error('The specified method for the request is invalid', $this->code405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->error('The specified URL cannot be found', $this->code404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->error('The specified model cannot be found', $this->code404);
        }

        if($exception instanceof OAuthServerException){
            return $this->error($exception->getMessage(), $this->code401);
        }

        if ($exception instanceof HttpException) {
            return $this->error($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof AuthenticationException){
            return $this->error($exception->getMessage(), $this->code401);
        }

        if($exception instanceof DecryptException){
            return $this->error($exception->getMessage(), $this->code422);
        }
        
        if ($exception instanceof Exception) {
            return $this->error($exception->getMessage(), $this->code404);
        }

        return parent::render($request, $exception);
    }
}

