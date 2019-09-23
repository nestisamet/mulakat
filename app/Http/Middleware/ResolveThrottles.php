<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ResolveThrottles extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $key = $this->resolveRequestSignature($request);

        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            return response()->json([
                'success' => false,
                'message' => [
                    'general' => [trans('msg.too_many_requests')]
                ],
            ],406
            );
        }

        $this->limiter->hit($key, $decayMinutes);

        return $this->addHeaders(
            $next($request),
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }
}
