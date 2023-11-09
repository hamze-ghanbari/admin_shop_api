<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
//           return response()->json(['error' => 'Not Found'], 404);
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Found',
                    'hasError' => true,
                    'result' => null
                ], 404);
            }elseif ($e instanceof RouteNotFoundException){
                return response()->json([
                    'status' => 500,
                    'message' => 'Internal Server Error',
                    'hasError' => true,
                    'result' => null
                ], 500);
            }elseif ($e instanceof MethodNotAllowedHttpException){
                return response()->json([
                    'status' => 405,
                    'message' => 'Method Not Allowed',
                    'hasError' => true,
                    'result' => null
                ], 405);
            }elseif($e instanceof BadMethodCallException){
                return response()->json([
                    'status' => 404,
                    'message' => 'Method Not Found',
                    'hasError' => true,
                    'result' => null
                ], 404);
            }
        });
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
//        if ($request->expectsJson()) {
            return response()->json([
                'messages' => 'Unauthorized',
                'status' => Response::HTTP_UNAUTHORIZED,
                'hasError' => true,
                'result' => null
            ], 401);
//        }
//
//        return redirect()->guest(route('login'));
    }
}
