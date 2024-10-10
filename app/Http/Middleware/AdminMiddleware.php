<?php

namespace App\Http\Middleware;

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
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            else{
                return redirect()->route('home');
            }
        }
        catch(\Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }
}
