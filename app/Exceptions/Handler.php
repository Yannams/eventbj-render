<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e){
        if ($e instanceof \Illuminate\Database\QueryException) {
            Log::error('Erreur de base de données : ' . $e ->getMessage());
            return response()->view('errors.database', [], 500);
        }

        if($e instanceof  \PDOException){
            Log::error('Erreur lors de la connexion à la base de données : ' . $e ->getMessage());
            return response()->view('errors.database', [], 500);
        }

        if ($e instanceof AuthenticationException) {
            return parent::render($request, $e);
        }

        if ($e instanceof ValidationException) {
            return parent::render($request, $e);

        }
        

        // if($e instanceof  \Exception){
        //     Log::error('une erreur inattendue s\'est produite : ' . $e ->getMessage());
        //     return response()->view('errors.general', [], 500);
        // }

       
        return parent::render($request, $e);


    }
}
