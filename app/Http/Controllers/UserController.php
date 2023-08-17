<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\Api;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Api;

    //
    public function store(UserRequest $request)
    {
        try {
            $payload = $request->only(['name', 'email', 'password']);

            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => Hash::make($payload['password'])
            ]);

            if ($user) {
                return $this->apiSuccess('Account has been created.', new UserResource($user));
            }

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
