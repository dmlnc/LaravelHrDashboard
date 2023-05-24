<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'media' => ThumbnailResource::collection($this->getMedia('user_avatar')),
            'email'=>$this->email,
            
            'roles' => $this->whenLoaded('roles', function () {
                    return $this->roles;
                })
            ];
    }
}
