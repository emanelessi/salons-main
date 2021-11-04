<?php

namespace App\Repositories;

use App\Http\Resources\editprofileResource;
use App\Http\Resources\educationResource;
use App\Http\Resources\experienceResource;
use App\Http\Resources\profileResource;
use App\Http\Resources\socialResource;
use App\Http\Resources\userResource;
use App\Models\Profile;
use App\Models\User;
use App\Models\User_education;
use App\Models\User_experience;
use App\Models\User_social;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;

class UserEloquent
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login()
    {
        $proxy = Request::create('oauth/token', 'POST');
        $response = Route::dispatch($proxy);
        $statusCode = $response->getStatusCode();
        $response = json_decode($response->getContent());
        if ($statusCode != 200)
            return response_api(false, $statusCode, $response->message, $response);
        $response_token = $response;
        $token = $response->access_token;
        \request()->headers->set('Authorization', 'Bearer ' . $token);

        $proxy = Request::create('api/profile', 'GET');
        $response = Route::dispatch($proxy);

        $statusCode = $response->getStatusCode();
        $response = json_decode($response->getContent());
        $user = \auth()->user();
        return response_api(true, $statusCode, 'Successfully Login', ['token' => $response_token, 'user' => $user]);

    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response_api(true, 200, 'Successfully Register!', $user->fresh());

    }

    public function profile($id = null)
    {
        if (isset($id)) {
            $user = User::find($id);
            if (!isset($user)) {
                return response_api(false, 422, 'Error', new \stdClass());
            }
        }
        $user = isset($id) ? $user : \auth()->user();
        return response_api(true, 200, 'Success', new profileResource($user));
    }

    public function editProfile(array  $data){
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->full_name = $data['full_name'];
        if ($data['email'] != null) {
            $user->email = $data['email'];
        }
        if ($data['password'] != null) {
            $user->password = bcrypt($data['password']);
        }
        if ($data['photo'] != null) {
            $user->img = $data['photo'];
        }
        $user->save();
        return response_api(true, 200, 'Successfully Updated!', ['profile' => new editprofileResource($user)]);
    }

}
