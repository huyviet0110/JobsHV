<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\RegisteringRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $checkExists = true;
        $user = User::query()
                    ->where('email', $data->getEmail())
                    ->first();

        if (is_null($user)) {
            $user        = new User();
            $user->email = $data->getEmail();
            $checkExists = false;
        }

        $user->name   = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();

        Auth::login($user);

        if ($checkExists) {
            $role = strtolower(UserRoleEnum::getKey($user->role));

            return redirect()->route("$role.welcome");
        }

        return redirect()->route('register');
    }

    public function registering(RegisteringRequest $request)
    {
        $password = Hash::make($request->get('password'));
        $role     = (int)$request->get('role');

        if (auth()->check()) {
            User::query()
                ->where('id', auth()->user()->id)
                ->update([
                    'password' => $password,
                    'role'     => $role,
                ]);
        } else {
            $user = User::query()->Create([
                'email'    => $request->get('email'),
                'name'     => $request->get('name'),
                'password' => $password,
                'role'     => $role,
            ]);

            Auth::login($user);
        }

        $role = strtolower(UserRoleEnum::getKey($role));

        return redirect()->route("$role.welcome");
    }
}
