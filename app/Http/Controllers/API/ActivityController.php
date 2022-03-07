<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreActivityRequest;
use App\Http\Requests\API\UpdateActivityRequest;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
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
     * @param  \App\Http\Requests\API\StoreActivityRequest  $request
     * @return JsonResponse
     */
    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->validated());
        if ($request->has('properties')) {
            $activity->properties = $request->input('properties');
            $activity->save();
        }

        return response()->json($activity, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Activitylog\Models\Activity  $activity
     * @return JsonResponse
     */
    public function show(Activity $activity)
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateActivityRequest  $request
     * @param  \Spatie\Activitylog\Models\Activity  $activity
     * @return JsonResponse
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Activitylog\Models\Activity  $activity
     * @return JsonResponse
     */
    public function destroy(Activity $activity)
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }
}
