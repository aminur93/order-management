<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * Register a new user based on the provided request data.
     *
     * @param Request $request The request object containing user data.
     * @return User The newly created user.
     * @throws \Throwable If an error occurs during user creation.
     */
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            return $user;

        }catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
