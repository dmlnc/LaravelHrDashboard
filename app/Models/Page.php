<?php

namespace App\Models;


use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'email',
        'phone',
        'questions',
        'about',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slider')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')
                    ->width(1200)
                    ->height(600)
                    ->fit('contain', 1200, 600);
            });

        $this->addMediaCollection('benefits')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')
                    ->width(600)
                    ->height(400)
                    ->fit('contain', 600, 400);
            });
    }
}