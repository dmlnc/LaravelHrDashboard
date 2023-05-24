<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'name' => $this->name,
            'vacancies' => $this->whenLoaded('vacancies', function () {
                return $this->vacancies->map(function ($vacancy) {
                    return [
                        'id' => $vacancy->id,
                        'name' => $vacancy->name,
                        'price_per_hour' => $vacancy->pivot->price_per_hour,
                    ];
                });
            }),
        ];
    }
}
