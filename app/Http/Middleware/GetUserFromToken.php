<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Response;


class GetUserFromToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->error(trans('auth.token_not_provided'), [], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return response()->error(trans('auth.login.token_expired'), [], Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return response()->error(trans('auth.invalid_token'), [], Response::HTTP_UNAUTHORIZED);
        }

        if (! $user) {
            return response()->error(trans('auth.user_not_found'), [], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
