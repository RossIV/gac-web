<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreEventRegistrationRequest;
use App\Http\Requests\API\UpdateEventRegistrationRequest;
use App\Models\EventRegistration;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\StoreEventRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRegistrationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateEventRegistrationRequest  $request
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRegistrationRequest $request, EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventRegistration $eventRegistration)
    {
        //
    }
}
