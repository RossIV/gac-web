<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PatchUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Display the current user
     *
     * @return JsonResponse
     */
    public function showSelf(Request $request): JsonResponse
    {
        $user = QueryBuilder::for(User::class)
            ->where('id', $request->user()->id)
            ->allowedIncludes([
                'nativeTeams', 'nativeTeams.registrations',
                'ownedNativeTeams', 'ownedNativeTeams.registrations',
                'currentTeam', 'invites',
                'affiliation',
                'signatures', 'signaturesPending',
                'eventRegistrations'
            ])
            ->first();
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PatchUserRequest $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(PatchUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        $user->refresh();
        return response()->json(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }
}
