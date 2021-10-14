<?php

namespace App\Exceptions;

use Exception;
use App\Http\Controllers\MailController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        $this->mail = new MailController; 

        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        //$exceptionTrace = method_exists($exception, 'gettrace') ? $exception->getTrace(): "";
        
        if($statusCode == 500){
            $errorExeception = [
                "status" => $statusCode,
                "message" => "Your request could not be completed ($statusCode). Please try again",
                "description" => class_basename($exception) . ' in ' . basename($exception->getFile()) . ' line ' . $exception->getLine() . ': ' . $exception->getMessage(),              
            ];
    
            $mailParams = [
                'Subject' => 'Payvice Web: An exception has occured',
                'Body' => 'An exception has occurred, please investigate',
                'template' => 'report',
                'data' => $errorExeception
            ];
            
            $send_mail = $this->mail->sendMail($mailParams);
            if($send_mail == true){
                \Log::info("Nice: Notification sent accordingly");
            } else {
                \Log::info("Error: Could not send Notification ");
            }
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

        return redirect()->guest(route('login'));
    }
}
