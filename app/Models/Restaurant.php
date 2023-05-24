<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name'];

    public function vacancies()
    {
        return $this->belongsToMany(Vacancy::class, 'restaurant_vacancy')->withPivot('price_per_hour')->withTimestamps();
    }
}
