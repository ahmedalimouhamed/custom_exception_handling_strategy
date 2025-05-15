<?php

use App\Exceptions\AppException;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    protected ExceptionHandler $base;

    public function __construct(ExceptionHandler $base)
    {
        $this->base = $base;
    }

    public function report(Throwable $e): void
    {
        if ($e instanceof AppException) {
            Log::error("Exception occurred: ", [
                'error'     => $e->getMessage(),
                'code'      => $e->getCode(),
                'context'   => $e->getContext(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);
        }

        $this->base->report($e);
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof AppException){

            Log::error("Exception occurred: ", [
                'error'     => $e->getMessage(),
                'code'      => $e->getCode(),
                'context'   => $e->getContext(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'context' => $e->getContext(),
            ], 400);
        }

        Log::error($e);
        return $this->base->render($request, $e);
    }
}