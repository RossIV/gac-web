<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SignatureCallbackRequest;
use App\Http\Requests\API\StoreSignatureRequest;
use App\Http\Requests\API\UpdateSignatureRequest;
use App\Models\Signature;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SignatureController extends Controller
{
    /**
     * @param SignatureCallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(SignatureCallbackRequest $request): JsonResponse
    {
        $document = $request->input('document');
        $event_uuid = $request->input('uuid');
        $event_type = $request->input('event_type');
        $event_time = $request->input('event_time');
        $event_hash = $request->input('event_hash');
        $timestamp = Carbon::parse($request->input('timestamp'));

        if ($request->has('document')) {
            $signer = $document['user'];
        } else {
            $data = ['document_name' => $document['name']];
            Log::error('Unable to identify signer for SignRequest callback', $data);
            return response()->json(['status' => 'failure'], 500);
        }

        $user = User::where('email', $signer['email'])->first();
        $signature = $user->signatures()->pending()->first();
        if (!$signature) {
            $data = ['signer' => json_encode($signer), 'document_name' => $document['name']];
            Log::error('No pending signatures for SignRequest callback', $data);
            return response()->json(['status' => 'failure'], 500);
        }

        if ($event_type === 'signer_viewed') {
            $signature->viewed_at = $timestamp;
        } elseif ($event_type === 'signed' || $event_type === 'signer_signed') {
            $signature->signed_electronically = true;
            $signature->signed_at = $timestamp;
            $signature->signed_file_url = $document['pdf'];
            $signature->signed_file_hash = $document['security_hash'];
            $signature->signing_log_url = $document['signing_log']['pdf'];
            $signature->signing_log_file_hash = $document['signing_log']['security_hash'];
        }

        $signature->save();
        activity()
            ->event($event_type)
            ->performedOn($signature)
            ->causedBy($user)
            ->withProperties([
                'event_uuid' => $event_uuid,
                'event_time' => $event_time,
                'event_hash' => $event_hash,
                'document_name' => $document['name']
            ])
            ->log('SignRequest Event Callback');

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
