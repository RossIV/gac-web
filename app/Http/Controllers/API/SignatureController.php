<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SignatureCallbackRequest;
use App\Http\Requests\API\StoreSignatureRequest;
use App\Http\Requests\API\UpdateSignatureRequest;
use App\Models\Signature;
use Illuminate\Http\JsonResponse;

class SignatureController extends Controller
{
    /**
     * @param SignatureCallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(SignatureCallbackRequest $request): JsonResponse
    {
        return response()->json(['status' => 'success']);
    }

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
     * @param  \App\Http\Requests\API\StoreSignatureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSignatureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\UpdateSignatureRequest  $request
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSignatureRequest $request, Signature $signature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signature $signature)
    {
        //
    }
}
