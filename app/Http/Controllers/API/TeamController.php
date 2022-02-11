<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreTeamRequest;
use App\Http\Requests\API\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\StoreTeamRequest  $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        // Allow for specifying owner by email, id, or default to requesting user
        if ($request->has('owner_email')) {
            $email = $request->input('owner_email');
            $owner = User::where('email', $email)->first();
            if (!$owner) {
                return response()->json(['status' => 'error', 'error' => "User '$email' not found"], 404);
            } else {
                $owner_id = $owner->id;
            }
        } elseif ($request->has('owner_id')) {
            $owner_id = $request->input('owner_id');
        } else {
            $owner_id = Auth::user()->id;
        }

        // Handle accepting terms
        if ($request->has('terms_agreed') && $request->input('terms_agreed') == true) {
            $terms_agreed_at = Carbon::now();
            $terms_agreed_by = Auth::user()->id;
        } else {
            $terms_agreed_at = $terms_agreed_by = null;
        }

        $team = Team::create([
            'name' => $request->input('name'),
            'motto' => $request->input('motto'),
            'accept_additional_members' => $request->input('accept_additional_members'),
            'owner_id' => $owner_id,
            'terms_agreed_at' => $terms_agreed_at,
            'terms_agreed_by' => $terms_agreed_by
        ]);

        // Handle adding team members in the same request, if present
        // Create (or use existing) user and invite them to the team
        if ($request->has('members')) {
            foreach ($request->input('members') as $member) {
                $user = User::firstOrCreate(
                  [ 'email' => $member->email ],
                  [
                      'first_name' => $member->first_name,
                      'last_name' => $member->last_name,
                      'alt_name' => $member->alt_name,
                      'phone' => $member->phone,
                      'affiliation_id' => $member->affiliation_id
                  ]
                );
                $invite = $team->invite($member->email);
            }
        }

        // Refresh team after adding/inviting members
        $team = Team::with('users', 'invites')->find($team->id);

        return response()->json(['status' => 'success', 'result' => $team], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return JsonResponse
     */
    public function show(Team $team): JsonResponse
    {
        return response()->json(['status' => 'success', 'result' => $team]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return JsonResponse
     */
    public function destroy(Team $team): JsonResponse
    {
        $team->delete();
        return response()->json(['status' => 'success']);
    }
}