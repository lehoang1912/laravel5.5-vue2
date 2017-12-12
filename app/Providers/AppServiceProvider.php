<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCustomResponse();
        $this->registerCustomValidate();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register custom response
     *
     * @return void
     */
    private function registerCustomResponse()
    {
        Response::macro('success', function ($message, $data = [], $statusCode = 200, $headers = []) {
            return response()->json([
                'status_code' => $statusCode,
                'message' => $message,
                'data' => $data
            ], $statusCode, $headers);
        });

        Response::macro('error', function ($message, $errors = [], $statusCode = 500, $headers = []) {
            return response()->json([
                'status_code' => $statusCode,
                'message' => $message,
                'errors' => $errors
            ], $statusCode, $headers);
        });

        Response::macro('notfound', function ($data, $errors = [], $statusCode = 404, $headers = []) {
            if ($data instanceof ModelNotFoundException) {
                $data = trans(sprintf('messages.%s.not_found', $data->getModel()));
            }
            return response()->json([
                'status_code' => $statusCode,
                'message' => $data,
                'errors' => $errors
            ], $statusCode, $headers);
        });
    }

    /**
     * Register custom validate
     *
     * @return void
     */
    private function registerCustomValidate()
    {
        /**
         * Validate data is phone number format
         */
        app('validator')->extend('phone_number', function ($attribute, $value, $parameters, $validator) {
            $regex = '/^([0-9\(\)\+ .-]{0,20})$/';
            $result = preg_match($regex, $value);
            if ($result === 1 || is_null($value)) {
                return true;
            }

            return false;
        });

        /**
         * Check the input password contains blank space
         */
        app('validator')->extendImplicit('password_valid_character', function ($attribute, $value) {
            if (is_string($value)) {
                return mb_strlen($value) === mb_strlen(trim($value));
            }
            return is_null($value);
        });
    }
}
