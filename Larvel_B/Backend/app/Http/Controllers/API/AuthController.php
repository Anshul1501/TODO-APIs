<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AuthController extends BaseController
{
 
   
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
     
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['user'] =  $user;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
  
    public function login(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Get credentials from request
        $credentials = $request->only('email', 'password');
    
        // Check if the user exists
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Compare password manually using Hash::check
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // If password is correct, generate token
        $token = JWTAuth::fromUser($user);
    
        // Return response with token and success message
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
    
    
   
    public function me()
{
    $user = JWTAuth::user();
    
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json([
        'message' => 'User data retrieved successfully',
        'user' => $user
    ]);
}

public function logout()
{
    try {
        $token = JWTAuth::getToken(); // Check if token is present
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 400);
        }

        // Validate and invalidate the token
        JWTAuth::invalidate($token);

        // Perform session flush and logout
        Session::flush();
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['error' => 'Invalid token'], 401);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred during logout'], 500);
    }
}


public function refresh()
{
    $newToken = JWTAuth::refresh();

    return response()->json([
        'message' => 'Token refreshed successfully',
        'access_token' => $newToken,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::factory()->getTTL() * 60
    ]);
} }
