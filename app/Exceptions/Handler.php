<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => 'Шумо ба система ворид нашудаед',
        ], 401);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Маълумоти воридшуда нодуруст аст',
                'errors' => $exception->errors(),
            ], $exception->status);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Шумо иҷозат надоред барои иҷрои ин амал',
            ], 403);
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Шумо иҷозат надоред барои иҷрои ин амал'
            ], 403);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $model . ' ёфт нашуд'
            ], 404);
        }

        if ($exception instanceof HttpExceptionInterface) {
            $messages = [
                403 => 'Шумо иҷозат надоред барои иҷрои ин амал',
                404 => 'Саҳифа ё маълумоти дархостшуда ёфт нашуд',
                405 => 'Ин усули дархост иҷозат дода нашудааст',
                419 => 'Мӯҳлати дархост ба анҷом расид, дубора кӯшиш кунед',
                429 => 'Шумораи дархостҳо аз ҳад зиёд аст, баъдтар дубора кӯшиш кунед',
            ];

            $status = $exception->getStatusCode();

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $messages[$status] ?? 'Хатогии дархост ба вуҷуд омад',
            ], $status);
        }

        if (!$this->isHttpException($exception) && !$this->shouldntReport($exception)) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Хатогии дохилии сервер ба вуҷуд омад',
            ], 500);
        }
    
        return parent::render($request, $exception);
    }
}
