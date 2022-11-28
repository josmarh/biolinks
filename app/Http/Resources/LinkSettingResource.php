<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkSettingResource extends JsonResource
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
            'tempUrlSchedule' => $this->tempurl_schedule,
            'tempUrlStartDate' => $this->tempurl_start_date,
            'tempUrlEndDate' => $this->tempurl_end_date,
            'tempUrlClickLimit' => $this->tempurl_click_limit,
            'tempUrlExpireUrl' => $this->tempurl_expire_url,
            'protectionPassword' => $this->protection_password,
            'protectionConsentWarning' => $this->protection_consent_warning,
            'targetType' => $this->target_type,
            'targetCountry' => $this->target_country,
            'targetDevice' => $this->target_device,
            'targetBrowserLang' => $this->target_browser_lang,
            'targetOS' => $this->target_os,
        ];
    }
}
