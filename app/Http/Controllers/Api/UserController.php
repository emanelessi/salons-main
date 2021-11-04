<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\SearchRequest;
use App\Http\Requests\User\ProfileRequest;
use App\Http\Requests\User\SignupRequest;
use App\Repositories\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserEloquent $userEloquent)
    {
        $this->user = $userEloquent;
    }

    public function login()
    {
        return $this->user->login();
    }

    public function register(SignupRequest $request)
    {
        return $this->user->register($request->all());

    }

    public function profile($id = null)
    {
        return $this->user->profile($id);

    }

    public function edit(ProfileRequest $request)
    {
        return $this->user->editProfile($request->all());
    }

}
