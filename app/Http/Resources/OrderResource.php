<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
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
            'orderType' => $this->order_type,
            'fulfilled' => $this->fulfilled,
            'status' => $this->status, 
            'description' => $this->description,
            'linkId' => $this->linkId,
            'sectionId' => $this->sectionId,
            'projectId' => $this->projectId,
            'total' => $this->total,
            'createdAt' => $this->created_at->format('Y-m-d')
        ];
    }
}
