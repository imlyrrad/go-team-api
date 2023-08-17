<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\Api;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    use Api;

    public function login(AuthRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->apiError('The provided credentials are incorrect', 401);
            }

            $token = $user->createToken('test')->plainTextToken;

            return $this->apiSuccess('', [
                'user' => new UserResource($user),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function logout()
    {
    }

    public function verify()
    {
        try {
            $id = Auth()->user()->id;
            $user = User::find($id);
            return $this->apiSuccess('', [
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
