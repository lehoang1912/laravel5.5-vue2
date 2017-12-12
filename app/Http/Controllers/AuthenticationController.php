<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthenticateService;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthenticationController extends Controller
{

    /**
     * JWTAuth
     *
     * @var JWTAuth
     */
    protected $auth;

    /**
     * AuthenticateService
     *
     * @var AuthenticateService
     */
    protected $authenticateService;

    /**
     * Constructor.
     *
     * @param JWTAuth             $auth                JWTAuth
     * @param AuthenticateService $authenticateService AuthenticateService
     */
    public function __construct(
        JWTAuth $auth,
        AuthenticateService $authenticateService
    ) {
        $this->auth = $auth;
        $this->authenticateService = $authenticateService;
    }

    /**
     * Login admin
     *
     * @param LoginRequest $request LoginRequest
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $data = trim_without_array($credentials, ['password']);

            $admin = $this->authenticateService->retrieveByCredentials($data);
            if ($admin == null || !$token = $this->auth->fromUser($admin)) {
                return response()->error(trans('auth.failed'), [], Response::HTTP_UNAUTHORIZED);
            }

            return response()->success(trans('auth.login.success'), [
                'token' => $token,
                'user_info' => $admin
            ]);
        } catch (JWTException $e) {
            return response()->error(trans('auth.failed'));
        } catch (Exception $ex) {
            return response()->error(trans('auth.failed'));
        }
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->auth->invalidate();

        return response()->success(trans('auth.logout.success'));
    }
}
