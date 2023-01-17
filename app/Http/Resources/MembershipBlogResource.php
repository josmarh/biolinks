<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MembershipBlogResource extends JsonResource
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
            'headlineColor' => $this->headline_color,
            'textColor' => $this->text_color,
            'bgColor' => $this->bg_color,
            'btnColor' => $this->button_color,
            'linkColor' => $this->link_color,
            'postBgColor' => $this->post_bg_color,
            'title' => $this->title,
            'subHeading' => $this->sub_heading,
            'disclaimer' => $this->disclaimer,
            'headerFontFamily' => $this->header_font_family,
            'textFontFamily' => $this->text_font_family,
            'posts' => $this->posts,
            'subsscriberAlert' => $this->subsscriber_alert,
            'subsscriberAlertColor' => $this->subsscriber_alert_color,
            'emailbox' => $this->emailbox,
            'postGatedContent' => $this->post_gated_content,
            'mainSetting' => json_decode($this->main_setting),
            'smedia' => json_decode($this->smedia),
        ];
    }
}
