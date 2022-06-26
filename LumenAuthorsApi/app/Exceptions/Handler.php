<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        // ? General Http errors
        if ($exception instanceof HttpException) {
            
            $code = $exception->getStatusCode();

            // we are going to build the message depending on the exception code
            //Attribute -> Response::$statusTexts[] array with all code states 404 => not found
            $message = Response::$statusTexts[$code];
            
            return $this->errorResponse($message, $code);
        }

        // * Model not found Exception 
        if ($exception instanceof ModelNotFoundException) {
            // we need the name of the model that has not been found
            $model = strtolower( class_basename($exception->getModel() ));

            
            // -- 
            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND);

        }

        // * Authorization
        if ($exception instanceof AuthorizationException) {
           
            // -- 
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);

        }

        // * Authentication
        if ($exception instanceof AuthenticationException) {
           
            // -- 
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

        }

        // * Validation form
        if ($exception instanceof ValidationException) {

            // Get all message errors already generated in validator object

            $errors = $exception->validator->errors()->getMessages();
           
            // -- 
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        // -- DEV Enviroment Excecution env file:  in case we dont want a generic error in Dev enviroment
        if (env('APP_DEBUG', false)) { // false default: it means production 
            
            return parent::render($request, $exception);
        }
        
        // ! Prod Enviroment General Uncontrolled Errors in production
        return $this->errorResponse('Unexpected error. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
