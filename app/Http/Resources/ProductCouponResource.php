<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCouponResource extends JsonResource
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
            'couponCode' => $this->coupon_code,
            'applyTo' => json_decode($this->apply_to),
            'discount' => json_decode($this->discount),
            'couponLimitType' => $this->coupon_limit_type,
            'couponLimitedCount' => $this->coupon_limited_count,
            'limitPerCustomer' => $this->limit_per_customer,
            'isExpires' => $this->is_expires,
            'expiryDate' => $this->expiry_date
        ];
    }
}
