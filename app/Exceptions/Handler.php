<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {

            switch ($exception->getStatusCode()) {
                case 404:
                    return response()->view('frontend.errors.error_404', [], 404);
                    break;
                case 403:
                    return response()->view('frontend.errors.error_403', [], 403);
                    break;
                default:
                    return response()->view('frontend.errors.error_maintain', []);
                    break;
            }
        } elseif ($exception->getMessage() == "Trying to get property of non-object") {
            return response()->view('frontend.errors.error_maintain', []);
        } elseif ($exception->getCode() == 23000) {
            return response()->view('frontend.errors.error_maintain', []);
        }
//        else{
//            return response()->view('frontend.errors.error_maintain', []);
//        }

        return parent::render($request, $exception);
    }
}
