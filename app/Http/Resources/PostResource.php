<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class PostResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'post' => $this->post,
            'images' => json_decode($this->images),
            'featuredImageStyle' => $this->featured_image_style,
            'media' => json_decode($this->media),
            'products' => json_decode($this->products),
            'courses' => json_decode($this->courses),
            'publishedDate' => $this->published_date,
            'author' => new UserResource($this->whenLoaded('user')),
            'categories' => json_decode($this->categories),
            'postPaymentSettings' => $this->payment_setting,
            'otp' => $this->otp,
            'contentPreview' => $this->content_preview,
            'plans' => json_decode($this->plans),
            'publishedStatus' => $this->published_status
        ];
    }
}
