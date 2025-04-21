<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticatedUserRequest;
use App\Http\Requests\HasPermissionRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest){
        $data = $loginRequest->validated();
        $validated = Http::withHeader('Accept', 'application/json')->post('nginx-auth-service/api/auth/login', $data);
        return $validated->body();
    }

    public function getAuthenticatedUser(AuthenticatedUserRequest $authenticatedUserRequest){
        $token = $authenticatedUserRequest->bearerToken();
        $user = Http::withHeader('Accept', 'application/json')
            ->withToken($token)
            ->get('nginx-auth-service/api/auth/user');

        return $user->json();
    }

    public function hasPermission(HasPermissionRequest $hasPermissionRequest){
        $token = $hasPermissionRequest->bearerToken();
        $data = $hasPermissionRequest->validated();
        $response = Http::withHeader('Accept', 'application/json')
            ->withToken($token)
            ->post('nginx-auth-service/api/auth/has-permission', $data);


        return $response->body();
    }

    public function logout(LogoutRequest $logoutRequest){
        $token = $logoutRequest->bearerToken();
        $response = Http::withHeader('Accept', 'application/json')
            ->withToken($token)
            ->get('nginx-auth-service/api/auth/logout');

        return $response->body();
    }
}
