<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
