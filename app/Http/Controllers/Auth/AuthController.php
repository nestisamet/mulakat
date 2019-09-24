<?php
namespace App\Http\Controllers\Auth;

use App\Events\Auth\Signout;
use App\Events\Auth\ValidAuth;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Validation\Data;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\AccountRepository;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Validation\Auth\AuthValidation;
use JWTAuth;
use App\Http\Resources\Account as AccountResource;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use RequestDataValidation,
        AuthValidation,
        ThrottlesLogins;

    /**
     * @param Request $request
     * @throws ApiException
     */
    protected function tooManyAttempts(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );
            throw new ApiException([
                'success' => false,
                'message' => [
                    'general' => [trans('auth.signin.throttle', ['seconds' => $seconds])]
                ],
            ]);
        }
    }

    /**
     * API Login
     * @param Request $request
     * @param AccountRepository $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request, AccountRepository $account)
    {
        $this->rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data, [], 'auth.attr');
            $this->tooManyAttempts($request);
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (!($token = JWTAuth::attempt($credentials))) {
                $this->incrementLoginAttempts($request);
                throw new ApiException([
                    'success' => false,
                    'message' => [
                        'general' => [trans('auth.signin.failed')]
                    ]
                ], 401);
            }
            /**
             * todo: >> event(new GecerliKimlikDogrulama());
             */
            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => [
                    'general' => [trans('auth.signin.success')]
                ],
                'accountInfo' => new AccountResource(auth()->user())
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
        catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => [
                    'general' => [trans('auth.signin.could_not_create_token')]
                ],
            ],
                500
            );
        }
    }

    /**
     * API log out
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout(Request $request)
    {
        try {
            $data = $request->only(array_keys($this->rules));
            $this->validateRequest($data);
            JWTAuth::invalidate();
            /**
             * todo: >> event(new Signout())
             */
            return response()->json([
                'success' => true,
                'message' => [
                    'general' => [trans('auth.signout.success')]
                ],
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
        catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],
                500
            );
        }
    }

    /**
     * jwt refresh
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $this->rules = [
            'token' => 'required',
        ];
        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data, [], 'auth.attr');
            JWTAuth::setToken($data['token']);
            if (!($token = JWTAuth::refresh())) {
                throw new ApiException([
                    'success' => false,
                    'message' => [
                        'general' => [trans('auth.refresh.failed')]
                    ]
                ], 401);
            }
            return response()->json([
                'success' => true,
                'token' => $token
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
        catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => [
                    'general' => [trans('auth.token_invalid')]
                ]
            ],
                500
            );
        }
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'email';
    }

}