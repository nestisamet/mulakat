<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\Check;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

/**
 * Class AuthJWT
 * @package App\Http\Middleware
 */
class AuthJWT extends Check
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->json([
                'success' => false,
                'code' => '1.0.0',
                'message' => [
                    'general' => [trans('auth.token_not_provided')]
                ],
            ],400
            );
        }

        try {
            $user = $this->auth->authenticate($token);
        }
        catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'code' => '1.0.1',
                'message' => [
                    'general' => [trans('auth.token_expired')]
                ],
            ], 401
            );
        }
        catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'code' => '1.0.2',
                'message' => [
                    'general' => [trans('auth.token_invalid')]
                ],
            ], 401
            );
        }

        if (!$user) {
            /**
             * token temiz ama iliskili hesap ucuruldu ise..
             */
            return response()->json([
                'success' => false,
                'code' => '1.0.3',
                'message' => [
                    'general' => [trans('auth.user_not_found')]
                ],
            ], 404);
        }
        /**
         * jwt ~ custom tanimlanmis claim i elimize alalim
         */
        // app()->setLocale($this->auth->getPayload()->get('foo'));
        return $next($request);
    }
}
