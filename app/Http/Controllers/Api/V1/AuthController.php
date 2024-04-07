<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Indentifiants incorrects'], 401);
        }
            
        $administrateur = Administrateur::where('email', $request['email'])->firstOrFail();
        $administrateur->tokens()->delete(); //supprimer les anciens tokens
        $token = $administrateur->createToken('token')->plainTextToken; //générer un nouveau token
        
        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * supprimer les tokens de l'utilisateur connecté
     */
    public function logout(Request $request)
    {
        $user = $request->user('sanctum');
        if ($user) {
            $user->tokens()->delete();
        }
    }
}
