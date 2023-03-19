<?php
namespace Jawa\Api\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if($request->wantsJson())
        {
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json(['error' => 'Method not allowed.', 'message' => $exception->getMessage()], 405);
            }
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['error' => 'Not found.', 'message' => $exception->getMessage()], 404);
            }
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['error' => 'Model not found.', 'message' => $exception->getMessage()], 404);
            }
            if ($exception instanceof AuthorizationException) {
                return response()->json(['error' => 'Forbidden.', 'message' => $exception->getMessage()], 403);
            }
            if ($exception instanceof BadRequestException) {
                return response()->json(['error' => 'Bad Request.', 'message' => $exception->getMessage()], 400);
            }
            if ($exception instanceof HttpException) {
                return response()->json(['error' => 'Http Exception.', 'message' => $exception->getMessage()], $exception->getStatusCode());
            }
        }
        return parent::render($request,$exception);
    }
}
