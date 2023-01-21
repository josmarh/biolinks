<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailProviderIntegrationResource extends JsonResource
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
            'mailchimp' => json_decode($this->mailchimp),
            'getresponse' => json_decode($this->getresponse),
            'emailoctopus' => json_decode($this->emailoctopus),
            'converterkit' => json_decode($this->converterkit),
            'mailerlite' => json_decode($this->mailerlite),
        ];
    }
}
