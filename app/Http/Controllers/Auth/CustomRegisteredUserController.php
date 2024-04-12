<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Http\Controllers\RegisteredUserController as FortifyRegisteredUserController;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Contracts\Auth\StatefulGuard;

class CustomRegisteredUserController extends FortifyRegisteredUserController
{
    protected $guard;
    public function __construct(StatefulGuard $guard)
    {
        $this->middleware('guest');
        $this->guard = $guard;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'max:20'],
            'profile_photo_path' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
    }

    public function store(Request $request,
      CreatesNewUsers $creator): RegisterResponse
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $this->guard->login($user);
        return app(RegisterResponse::class);
    }

}