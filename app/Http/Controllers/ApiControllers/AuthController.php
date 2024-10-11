<?php

namespace App\Http\Controllers\ApiControllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $errorHandler;
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function register(RegisterRequest $request)
    {
        try{
            $validatedData = $request->validated();
            if($request->hasFile('image')){
                $validatedData['image'] = Storage::putFile('users',$request->file('image'));
            }
            $user = User::create($validatedData);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $user,
            ],Response::HTTP_CREATED);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }

    public function login(LoginRequest $request)
    {
        try{
        $validatedData = $request->validated();
        if(!Auth::attempt($validatedData)){
            return response()->json([
               'message' => 'Invalid credentials',
            ],Response::HTTP_UNAUTHORIZED);                                  
        }
        $user = Auth::user();
        $token = $user->createToken('Api Token')->plainTextToken;
        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
        ],Response::HTTP_OK);
        }
        catch(Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return response()->json([
                'message' => 'User logged out successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());

            return $this->errorHandler->handleException($e);
        }
    }
}
