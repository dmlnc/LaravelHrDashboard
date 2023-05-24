<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Vacancy extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'description'];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_vacancy')->withPivot('price_per_hour')->withTimestamps();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $thumbnailWidth  = 50;
        $thumbnailHeight = 50;

        // $thumbnailPreviewWidth  = 300;
        // $thumbnailPreviewHeight = 300;

        $previewWidth = 400;
        $previewHeight = 500;

        $this->addMediaConversion('thumbnail')
            ->width($thumbnailWidth)
            ->height($thumbnailHeight)
            ->fit('crop', $thumbnailWidth, $thumbnailHeight);
        // $this->addMediaConversion('preview_thumbnail')
        //     ->width($thumbnailPreviewWidth)
        //     ->height($thumbnailPreviewHeight)
        //     ->fit('crop', $thumbnailPreviewWidth, $thumbnailPreviewHeight);

        $this->addMediaConversion('preview')
            ->width($previewWidth)
            ->height($previewHeight)
            ->fit('contain', $previewWidth, $previewHeight);
    }
}
