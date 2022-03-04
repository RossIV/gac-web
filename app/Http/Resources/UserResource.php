<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'alt_name' => $this->alt_name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            $this->mergeWhen($this->requestingSelf($request) || Auth::user()->can('read-users-emergency-contact'), [
                'emergency_contact_name' => $this->emergency_contact_name,
                'emergency_contact_phone' => $this->emergency_contact_phone,
                'emergency_contact_relationship' => $this->emergency_contact_relationship,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'affiliation_id' => $this->affiliation_id,
            'affiliation' => AffiliationResource::make($this->whenLoaded('affiliation')),
            'activities' => $this->whenLoaded('activities'),
            'profile_complete' => $this->profileComplete,
            'teams' => TeamResource::collection($this->whenLoaded('nativeTeams')),
            'ownedTeams' => TeamResource::collection($this->whenLoaded('ownedNativeTeams')),
            'currentTeam' => TeamResource::make($this->whenLoaded('currentTeam')),
            'teamInvites' => $this->whenLoaded('invites'),
            'signatures' => SignatureResource::collection($this->whenLoaded('signatures')),
            'signaturesPending' => SignatureResource::collection($this->whenLoaded('signaturesPending')),
            'eventRegistrations' => EventRegistrationResource::collection($this->whenLoaded('eventRegistrations'))
        ];
    }

    protected function requestingSelf(Request $request): bool
    {
        return $request->user()->id === $this->id;
    }
}
