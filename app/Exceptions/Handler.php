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

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e): Response
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

    public function register(): void
    {
        //
    }
}
