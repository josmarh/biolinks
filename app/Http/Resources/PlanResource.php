<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'unlockType' => $this->unlock_type,
            'monthlyPricing' => $this->monthly_pricing,
            'monthlyPrice' => $this->monthly_price,
            'annualPricing' => $this->annual_pricing,
            'annualPrice' => $this->annual_price,
            'action' => json_decode($this->action),
        ];
    }
}
