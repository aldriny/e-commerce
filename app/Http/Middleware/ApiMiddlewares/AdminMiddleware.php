<?php

namespace App\Http\Middleware\ApiMiddlewares;

use App\Helpers\ErrorHandler;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
            if(Auth::user()->role === 'admin'){
                return $next($request);
            }
            return response()->json([
                'error' => 'Unauthorized',
               'message' => 'You are not authorized to access this resource.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        catch(\Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }
}
