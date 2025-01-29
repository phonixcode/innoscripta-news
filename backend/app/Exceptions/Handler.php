<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle Validation Errors
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation errors occurred',
                'errors' => $exception->errors(),
            ], 422);
        }

        // Handle Unauthenticated Users (API Specific)
        if ($exception instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User is not authenticated',
                ], 401); 
            }

            return redirect()->route('login'); 
        }

        // Handle Route Not Found (if route is missing)
        if ($exception instanceof RouteNotFoundException) {
            return response()->json([
                'status' => 'error',
                'message' => 'The route you are trying to access does not exist.',
            ], 404);
        }

        // Default exception handling
        return parent::render($request, $exception);
    }
}
