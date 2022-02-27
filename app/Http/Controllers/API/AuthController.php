<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthLoginRequest;
use App\Http\Requests\API\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        $user->sendLoginLink();

        activity('auth')
            ->event('login')
            ->performedOn($user)
            ->withProperties([
                'ip' => $request->ip(),
            ])
            ->log('Magic Link Requested');

        return response()->json(['status' => 'success']);
    }

    /**
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $user->sendLoginLink();

        activity('auth')
            ->event('register')
            ->performedOn($user)
            ->withProperties([
                'ip' => $request->ip(),
            ])
            ->log('New user registration');

        return response()->json(['status' => 'success'], 201);
    }
}
