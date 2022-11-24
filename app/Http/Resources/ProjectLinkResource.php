<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class ProjectLinkResource extends JsonResource
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
            'projectId' => $this->project_id,
            'linkId' => $this->link_id,
            'type' => $this->type,
            'linkTypeUrl' => $this->long_url,
            'uniqueClicks' => $this->total_unique_clicks,
            'leads' => $this->total_leads,
            'status' => $this->status,
            'createdBy' => new UserResource($this->whenLoaded('user')),
            'createdAt' => Carbon::create($this->created_at)->toDayDateTimeString(),
        ];
    }
}
