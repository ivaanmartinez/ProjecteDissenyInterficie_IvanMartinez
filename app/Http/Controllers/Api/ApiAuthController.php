<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppToken')->plainTextToken;

            // Ara també retornem l'ID de l'usuari
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id, // Retornem l'ID de l'usuari
                ]
            ]);
        }

        return response()->json(['error' => 'Credencials incorrectes'], 401);
    }
}
