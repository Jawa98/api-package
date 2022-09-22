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
                return response()->json(['message' =>
                 'Method not allowed.'], 405);
            }
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['message' => 'Not found.'], 404);
            }
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Model not found.'], 404);
            }
            if ($exception instanceof AuthorizationException) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            if ($exception instanceof BadRequestException) {
                return response()->json(['message' => 'Bad Request.'], 400);
            }
            if ($exception instanceof HttpException) {
                return response()->json($exception->getMessage(), $exception->getStatusCode());
            }
        }
        return parent::render($request,$exception);
    }
}
