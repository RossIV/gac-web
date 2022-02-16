<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreAffiliationRequest;
use App\Http\Requests\API\UpdateAffiliationRequest;
use App\Models\Affiliation;
use Illuminate\Http\JsonResponse;

class AffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $affiliations = Affiliation::get();

        return response()->json($affiliations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\StoreAffiliationRequest  $request
     * @return JsonResponse
     */
    public function store(StoreAffiliationRequest $request): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Affiliation  $affiliation
     * @return JsonResponse
     */
    public function show(Affiliation $affiliation): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateAffiliationRequest  $request
     * @param  \App\Models\Affiliation  $affiliation
     * @return JsonResponse
     */
    public function update(UpdateAffiliationRequest $request, Affiliation $affiliation): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Affiliation  $affiliation
     * @return JsonResponse
     */
    public function destroy(Affiliation $affiliation): JsonResponse
    {
        return response()->json(['status' => 'error', 'error' => 'Not implemented'], 501);
    }
}
