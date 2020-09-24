<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (\Exception $e, $request) {
            if ($request->is('api/v1/*')) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
                    return response()->json(['message' => 'Not Found!'], 404);
                elseif ($e instanceof \GuzzleHttp\Exception\ClientException || $e instanceof \GuzzleHttp\Exception\ServerException)
                    return response()->json(json_decode($e->getResponse()->getBody()->getContents()), $e->getResponse()->getStatusCode());
                else
                    return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
            }

            // return parent::render($request, $e);
        });
    }
}
