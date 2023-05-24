<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'birthday',
        'phone',
        'social',
        'restaurant_id',
        'vacancy_id',
        'is_archive',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
