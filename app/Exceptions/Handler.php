<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Session\TokenMismatchException;
use Mail;


class Handler extends ExceptionHandler
{
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
        // log errors only in production mode and it's not http exception
        if (env('APP_ENV') == 'production') {

            if ($this->shouldntReport($exception)) {
                return;
            }

            $exceptionHtml = $this->convtExceptionToResponse($exception)->getContent();

            Mail::to('daud4b@gmail.com')->send(new \App\Mail\ExceptionOccured($exceptionHtml));
        }
        
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
        if ($exception instanceof TokenMismatchException) {
            return $this->csrfTokenExpirationHandler($request);
        }
        
        if(!config('app.debug'))
        {   
            return $this->renderException($request,$exception);
        }

        return parent::render($request, $exception);
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
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        
        if($exception->guards()[0] == 'web')
        {
            return redirect()->guest(route('admin.login'));
        }

        return redirect(route('front.vote.login'));
    }

    protected function csrfTokenExpirationHandler($request)
    {
        return redirect()
            ->back()
            ->withInput(
                $request->except(
                    'password', 
                    'password_confirmation',
                    '_token'
                )
            )
            ->with([
                'error' => 'Your form has expired. Please try again'
            ]);
    }


    /**
     * Render an exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * 
     */
    protected function renderException($request, Exception $e)
    {  
        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) { //dd('auth');
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }elseif($e instanceof NotFoundHttpException){
            return $this->prepareResponse($request,$e);
        }else{
            error_reporting(0);
            return response()->view('errors.500', [], 500);
        }
    }
}
