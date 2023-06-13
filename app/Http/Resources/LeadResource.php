<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'surname' => $this->surname,
            'birthday' => $this->birthday,
            'age' => $this->calculateAge($this->birthday),
            'phone' => $this->phone,
            'social' => $this->social,
            'is_archive' => $this->is_archive,
            'restaurant' => [
                'id' => $this->restaurant ? $this->restaurant->id : null,
                'name' => $this->restaurant ? $this->restaurant->name : null,
            ],
            'vacancy' => [
                'id' => $this->vacancy ? $this->vacancy->id : null,
                'name' => $this->vacancy ? $this->vacancy->name : null,
            ],
            'created_at' => $this->created_at->format('d.m.y H:i'),
        ];
    }

    /**
     * Calculate the age based on the given birthday string.
     *
     * @param string $birthday
     * @return int|null
     */
    private function calculateAge($birthday)
    {
        if ($birthday) {
            $birthdayDate = \DateTime::createFromFormat('d.m.Y', $birthday);
            $now = new \DateTime();
            $interval = $now->diff($birthdayDate);
            return $interval->y;
        }
        return null;
    }
}
