<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BiolinkSectionResource extends JsonResource
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
            'section' => new BiolinkSectionSettingResource($this->whenLoaded('section')),
            'buttonText' => $this->button_text,
            'buttonTextColor' => $this->button_text_color,
            'buttonBgColor' => $this->button_bg_color,
            'sectionFields' => json_decode($this->core_section_fields),
        ];
    }
}
