<?php

namespace App\Http\Resources;

use App\Models\EventRegistration;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'motto' => $this->motto,
            'accept_additional_members' => $this->accept_additional_members,
            'terms_agreed' => $this->terms_agreed,
            'terms_agreed_at' => $this->terms_agreed_at,
            'terms_agreed_by' => $this->terms_agreed_by,
            'owner_id' => $this->owner_id,
            'registrations' => EventRegistrationResource::collection($this->whenLoaded('registrations')),
            'invitedUsers' => UserResource::collection($this->whenLoaded('invitedUsers')),
            'invitedUsersCount' => $this->invitedUsers->count(),
            'activities' => $this->whenLoaded('activities'),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'usersCount' => $this->users->count(),
            'owner' => UserResource::make($this->whenLoaded('owner'))
        ];
    }
}
