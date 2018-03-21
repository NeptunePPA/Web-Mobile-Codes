<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Contracts\Auth\Guard;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Auth;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(Guard $auth)
    {

        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $validateAll = false)
    {
        try{
            $user = JWTAuth::toUser($request->header('Authorization'));

        }catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message'=>'token_expired','status'=>4], $e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message'=>'token_invalid','status'=>4], $e->getStatusCode());
            }else{
                return response()->json(['message'=>'Token is required','error'=>'Token is required','status'=>4]);
            }
        }

        return $next($request);
    }
}
