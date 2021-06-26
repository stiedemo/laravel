<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function render($request, Throwable $exception)
    {
        if($request->route() != null) {
            if(strpos($request->route()->getPrefix(),'api') !== false) {
                try {
                    if ($exception instanceof ModelNotFoundException) {
                        return response()->json(api_errors_common("Không tìm thấy dữ liệu", []), Response::HTTP_NOT_FOUND);
                    }
                    $returnCode = $exception->getStatusCode();
                } catch (Throwable $th) {
                    $returnCode = Response::HTTP_BAD_REQUEST;
                }
                return response()->json(api_errors_common($exception->getMessage(), []), $returnCode);
            } else {
                return parent::render($request, $exception);
            }
        } else {
            return response()->json(api_errors_common("Đường dẫn không tồn tại", []), Response::HTTP_NOT_FOUND);
        }
    }
}
