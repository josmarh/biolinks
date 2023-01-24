<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerLeadResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status,
            'orders' => $this->orders,
            'lifetimeValue' => $this->lifetime_value,
            'projectId' => $this->project_id
        ];
    }
}
