<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreEventRegistrationRequest;
use App\Http\Requests\API\UpdateEventRegistrationRequest;
use App\Models\EventRegistration;
use Illuminate\Http\JsonResponse;

class EventRegistrationController extends Controller
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
     * @param  \App\Http\Requests\API\StoreEventRegistrationRequest  $request
     * @return JsonResponse
     */
    public function store(StoreEventRegistrationRequest $request): JsonResponse
    {
        $registration = EventRegistration::create([
            'event_id' => $request->input('event_id'),
            'team_id' => $request->input('team_id'),
            'user_id' => $request->input('user_id', $request->user()->id),
        ]);

        if ($request->has('payment_method_id')) {
            $payment = $registration->payments()->create([
                'payment_method_id' => $request->input('payment_method_id'),
                'amount' => 0.00
            ]);
        }

        // Refresh registration after adding payment
        $registration = EventRegistration::with('payments',)->find($registration->id);
        return response()->json(['status' => 'success', 'result' => $registration]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return JsonResponse
     */
    public function show(EventRegistration $eventRegistration): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateEventRegistrationRequest  $request
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return JsonResponse
     */
    public function update(UpdateEventRegistrationRequest $request, EventRegistration $eventRegistration): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return JsonResponse
     */
    public function destroy(EventRegistration $eventRegistration): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }
}
