<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'instructions' => $this->instructions,
            'is_active' => $this->is_active,
            'additional_info_required' => $this->additional_info_required,
            'additional_info_instructions' => $this->additional_info_instructions,
            'fee' => $this->fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'payments' => PaymentResource::collection($this->whenLoaded($this->payments))
        ];
    }
}
