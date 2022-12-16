<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class AdminProjectResource extends JsonResource
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
            'links' => $this->links,
            'collaborators' => $this->collaborators,
            'owner' => $this->owner,
            'createdAt' => Carbon::create($this->created_at)->toDayDateTimeString()
        ];
    }
}
