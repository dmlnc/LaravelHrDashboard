<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'media_slider' => ThumbnailResource::collection($this->getMedia('slider')),
            'media_benefits' => ThumbnailResource::collection($this->getMedia('benefits')),
            'about' => $this->about,
            'email' => $this->email,
            'phone' => $this->phone,
            'questions' => json_decode($this->questions),
            
        ];
    }
}
