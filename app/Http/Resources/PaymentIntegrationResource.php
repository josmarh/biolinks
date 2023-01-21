<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentIntegrationResource extends JsonResource
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
            'stripeStatus' => $this->stripe_status,
            'stripeSecret' => $this->stripe_secret,
            'paypalStatus' => $this->paypal_status,
            'paypalSecret' => $this->paypal_secret,
            'paypalClient' => $this->paypal_client,
        ];
    }
}
