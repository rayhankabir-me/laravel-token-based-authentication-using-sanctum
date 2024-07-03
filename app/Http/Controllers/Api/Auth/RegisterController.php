<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\password;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ],201);
    }
}
