<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class AdminProjectLinkResource extends JsonResource
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
            'linkId' => $this->link_id,
            'associateProject' => new ProjectResource($this->whenLoaded('project')),
            'type' => $this->type,
            'status' => $this->status,
            'createdBy' => new UserResource($this->whenLoaded('user')),
            'createdAt' => Carbon::create($this->created_at)->toDayDateTimeString(),
        ];
    }
}
