<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SignatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'event_registration_id' => $this->event_registration_id,
            'signed_electronically' => $this->signed_electronically,
            'signed_file_url' => $this->signed_file_url,
            'signed_file_hash' => $this->signed_file_hash,
            'signing_log_url' => $this->signing_log_url,
            'signing_log_file_hash' => $this->signing_log_file_hash,
            'requested_at' => $this->requested_at,
            'viewed_at' => $this->viewed_at,
            'signed_at' => $this->signed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'document_url' => $this->documentUrl,
            'user' => UserResource::make($this->whenLoaded('user')),
            'event_registration' => EventRegistrationResource::make($this->whenLoaded('eventRegistration'))
        ];
    }
}
