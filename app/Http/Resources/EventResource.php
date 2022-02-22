<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'registration_starts_at' => $this->registration_starts_at,
            'registration_ends_at' => $this->registration_ends_at,
            'location' => $this->location,
            'participant_waiver_url' => $this->participant_waiver_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'registrations' => EventRegistrationResource::collection($this->whenLoaded('registrations')),
            'registeredTeams' => TeamResource::collection($this->whenLoaded('registeredTeams'))
        ];
    }
}
