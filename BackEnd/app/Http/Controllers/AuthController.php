<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','status']]);
    }

    /**
     * Register a test user
     * user name: test@test.com
     * password: default
     */
    public function register()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('default')
        ]);
        return response()->json($user, 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Usuario o contraseña no valido'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        Session::flush();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            'user_id' => auth()->id(),
            'Token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 180
            ]
        ];
        return response()->json($data);
    }

    protected function status()
    {
        $data = [
            'build' => '0.1.0',
            'codename' => 'MicroERP'
        ];
        return response()->json($data);
    } 
}
