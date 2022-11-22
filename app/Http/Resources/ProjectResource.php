<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'projectId' => $this->custom_id,
            'totalLinks' => $this->total_links,
            'uniqueClicks' => $this->total_unique_clicks,
            'createdAt' => Carbon::create($this->created_at)->toDayDateTimeString()
        ];
    }
}
