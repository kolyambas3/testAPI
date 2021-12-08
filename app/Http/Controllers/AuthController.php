<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/register",
     *   summary="Register a new user",
     *   @OA\Response(
     *     response=200,
     *     description="Register user"
     *   ),
     *   @OA\Parameter(
     *      description="Name of user",
     *      in="path",
     *      name="name",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *   @OA\Parameter(
     *      description="Email of user",
     *      in="path",
     *      name="email",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *     @OA\Parameter(
     *      description="Password of user",
     *      in="path",
     *      name="password",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="key"
     *   )
     * )
     */
    public function register(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     *   path="/login",
     *   summary="Login user",
     *   @OA\Response(
     *     response=200,
     *     description="Login user"
     *   ),
     *   @OA\Parameter(
     *      description="Email of user",
     *      in="path",
     *      name="email",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *     @OA\Parameter(
     *      description="Password of user",
     *      in="path",
     *      name="password",
     *      required=true,
     *      @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="key"
     *   )
     * )
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email
        )->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
