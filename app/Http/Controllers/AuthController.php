<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @api {post} /register Regisztráció
     * @apiName Register
     * @apiGroup Auth
     * @apiVersion 1.0.0
     * @apiDescription Új felhasználót hoz létre és visszaad egy Bearer tokent.
     *
     * @apiBody {String} name Név
     * @apiBody {String} email E-mail cím
     * @apiBody {String} password Jelszó (min. 8 karakter)
     *
     * @apiSuccess (201) {String} token Bearer token
     * @apiSuccessExample {json} Siker (201):
     *     {"token": "1|abc123...", "user": {"id": 1, "name": "Teszt Elek", "email": "teszt@example.com"}}
     * @apiError (422) ValidationError Hibás vagy hiányzó mező
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($data);

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user,
        ], 201);
    }

    /**
     * @api {post} /login Bejelentkezés
     * @apiName Login
     * @apiGroup Auth
     * @apiVersion 1.0.0
     * @apiDescription E-mail és jelszó alapján Bearer tokent ad.
     *
     * @apiBody {String} email E-mail cím
     * @apiBody {String} password Jelszó
     *
     * @apiSuccess {String} token Bearer token
     * @apiSuccessExample {json} Siker (200):
     *     {"token": "2|xyz789...", "user": {"id": 1, "name": "Teszt Elek", "email": "teszt@example.com"}}
     * @apiError (401) Unauthorized Hibás e-mail vagy jelszó
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Hibás e-mail vagy jelszó.'], 401);
        }

        return response()->json([
            'token' => Auth::user()->createToken('api')->plainTextToken,
            'user' => Auth::user(),
        ]);
    }
}
