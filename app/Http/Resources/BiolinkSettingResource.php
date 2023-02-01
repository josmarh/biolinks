<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BiolinkSettingResource extends JsonResource
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
            'linkId' => $this->link_id,
            'topLogo' => $this->top_logo,
            'video' => json_decode($this->video),
            'title' => $this->title,
            'textColor' => $this->text_color,
            'verifiedCheckmark' => $this->verified_checkmark,
            'description' => $this->description,
            'backgroundType' => $this->background_type,
            'backgroundTypeContent' => json_decode($this->background_type_content),
            'branding' => json_decode($this->branding),
            'analytics' => json_decode($this->analytics),
            'seo' => json_decode($this->seo),
            'utm' => json_decode($this->utm),
            'socials' => json_decode($this->socials),
            'font' => $this->font,
            'showMemberNavbar' => $this->show_member_navbar
        ];
    }
}
