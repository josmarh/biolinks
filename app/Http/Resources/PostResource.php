<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'images' => $this->images,
            'featuredImageStyle' => $this->featured_image_style,
            'media' => $this->media,
            'products' => $this->products,
            'courses' => $this->courses,
            'publishedDate' => $this->published_date,
            'author' => $this->author,
            'categories' => $this->categories,
            'paymentSetting' => $this->payment_setting,
            'publishedStatus' => $this->published_status
        ];
    }
}
