<?php

namespace App\Http\Middleware\ApiMiddlewares;

use App\Helpers\ErrorHandler;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json([
                    'error' => 'Access token is required'
                ], Response::HTTP_UNAUTHORIZED);
            }
            
            $user = User::where('access_token', $request->bearerToken())->first();
            if (!$user) {
                return response()->json([
                    'error' => 'Invalid access token'
                ], Response::HTTP_UNAUTHORIZED);
            }

            Auth::setUser($user);
            $request->setUserResolver(function() use ($user){
                return $user;
            });

            return $next($request);
        }
        catch (\Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }
}
