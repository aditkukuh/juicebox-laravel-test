<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;
use Exception; // Import Exception class

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }
    
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $response['token'] =  $user->createToken('MyApp')->plainTextToken;
            $response['name'] =  $user->name;
    
            return $this->sendResponse($response, 'User register successfully.');
        } catch (Exception $e) {
            return $this->sendError('Registration failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
                $user = Auth::user(); 
                $response['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $response['name'] =  $user->name;
    
                return $this->sendResponse($response, 'User login successfully.');
            } else { 
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $e) {
            return $this->sendError('Login failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->sendResponse([], 'User logged out successfully.');
        } catch (Exception $e) {
            return $this->sendError('Logout failed', ['error' => $e->getMessage()]);
        }
    }
}