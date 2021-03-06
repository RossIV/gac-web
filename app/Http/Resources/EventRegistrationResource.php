<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventRegistrationResource extends JsonResource
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
            'submitted_by' => new UserResource($this->user),
            'event' => new EventResource($this->event),
            'team' => new TeamResource($this->team),
            'payment_due' => $this->paymentDue,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'external_notes' => $this->external_notes,
            'internal_notes' => $this->when(Auth::user()->can('read-internal-data'), $this->internal_notes),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
