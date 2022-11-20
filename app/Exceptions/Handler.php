<?php

namespace App\Exceptions;

use App\Helpers\UtilsHelper;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthorized.'], 401);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return JsonResponse|Response
     */
    public function render($request, Throwable $exception)
    {
        // UNAUTHORIZED
        if ($exception instanceof AuthenticationException) {
            if($request->path() === 'refresh'){
                // Logování při neúspěšné obnově tokenu.
                Log::notice("Failed to refresh token. Token: ".$request['token']);
            }
            Log::debug("UNAUTHORIZED : [" . ($_SERVER['HTTP_AUTHORIZATION'] ?? '') . "] time: [" . $_SERVER['REQUEST_TIME'] . "]");
            return UtilsHelper::unauthorizedResponseJson();
        }

        // PERMISSION DENIED
        if ($exception instanceof AuthorizationException) {
            return UtilsHelper::permissionDeniedResponseJson($exception);
        }

//        if ($exception instanceof ModelDuplicateException) {
//            return UtilsHelper::duplicateObjectJson();
//        }

        // NOT FOUND
        if ($exception instanceof NotFoundException) {
            return UtilsHelper::notFoundResponseJson($exception->getMessage());
        }

        // VALIDATION
        if ($exception instanceof ValidatorException) {
            return UtilsHelper::validationErrorResponseJson($exception);
        }

        if ($exception instanceof UserAlreadyHasGameException) {
            return UtilsHelper::userAlreadyHasGameResponseJson($exception);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            Log::debug("METHOD NOT ALLOWED : [" . ($_SERVER['HTTP_AUTHORIZATION'] ?? "undefined") . "] time: [" . $_SERVER['REQUEST_TIME'] . "]");
            return UtilsHelper::notFoundResponseJson();
        }

        if ($exception instanceof NotImplementedException) {
            return UtilsHelper::notImplementedResponseJson();
        }

        // Error messages provided by backend to be reported within front end
        if ($exception instanceof ReportedException) {
            return UtilsHelper::reportedErrorResponse($exception);
        }

        // basic auth exceptions
        if ($exception instanceof UnauthorizedHttpException || $exception instanceof MaintenanceModeException) {
            return parent::render($request, $exception);
        }

        /**
         * Try to handle connection issues of database and provide 503 status to frontend
         *
         * @see https://gitlab.ogapps.cloud/skoda/sledovani-klt/client-angular/-/issues/54
         */
        if ($exception instanceof \PDOException) {

            // log exception anyway
            Log::error($exception->getMessage(), $exception->getTrace());

            switch ($exception->getCode()) {
                case 'HY000':
                    // SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it.
                case 'HYT00':
                    // Timeout expired
                    abort(503, 'MSSQL server is not available - connection issues. Try again.');
            }
        }

        // we want all exceptions during dev
        if (env('APP_DEBUG')) {
            return parent::render($request, $exception);
        }

        return response()->json(['error' => 'Internal server error'], 500);
    }
}
