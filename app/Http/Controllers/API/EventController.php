<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreEventRequest;
use App\Http\Requests\API\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $events = QueryBuilder::for(Event::class)
            ->allowedFilters([
                AllowedFilter::scope('active'),
                AllowedFilter::scope('active_registration'),
                AllowedFilter::scope('starts_after'),
            ])
            ->get();

        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\StoreEventRequest  $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return JsonResponse
     */
    public function show(Event $event): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return JsonResponse
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return JsonResponse
     */
    public function destroy(Event $event): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }
}
