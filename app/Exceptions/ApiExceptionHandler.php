<?php

namespace App\Exceptions;

use App\Exceptions\AppException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


class ApiExceptionHandler extends ExceptionHandler
{
    protected ExceptionHandler $base;

    public function __construct(ExceptionHandler $base)
    {
        $this->base = $base;
    }

    public function report(Throwable $e): void
    {
        $this->base->report($e);
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof AuthenticationException){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        if($e instanceof ValidationException){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        if($e instanceof ModelNotFoundException){
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
            ], 404);
        }

        if($e instanceof HttpExceptionInterface){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'HTTP error',
            ], $e->getStatusCode());
        }

        if($e instanceof AppException){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        }

        return $this->base->render($request, $e);
    }
}