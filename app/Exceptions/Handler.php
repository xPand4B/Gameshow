<?php

namespace App\Exceptions;

use App\Http\Resources\Error\ErrorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $parameter = explode('/', $request->fullUrl());
            $parameter = $parameter[sizeof($parameter) - 1];

            $model = explode('\\', $e->getModel());
            $model = mb_strtolower($model[sizeof($model) - 1]);

            return (new ErrorResource())
                ->setSource('/database/models/'.$model, $parameter)
                ->setDetail("Entry for '".$model."' not found.")
                ->setStatusCode(404)
                ->getError();
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
