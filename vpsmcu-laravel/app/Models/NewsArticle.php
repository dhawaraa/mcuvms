<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $table = 'news_articles';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function getLocalizedTitleAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        return $this->title;
    }

    public function getLocalizedContentAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->content_en)) {
            return $this->content_en;
        }
        return $this->content;
    }

    public function getCoverImageUrlAttribute()
    {
        if (empty($this->cover_image)) {
            return null;
        }
        // Normalize /storage/... to /storage.php/... for shared hosting environments
        if (str_starts_with($this->cover_image, '/storage/')) {
            return '/storage.php/' . substr($this->cover_image, 9);
        }
        return $this->cover_image;
    }

    public function getCoverImageAttribute($value)
    {
        if (!empty($value) && str_starts_with($value, '/storage/')) {
            return '/storage.php/' . substr($value, 9);
        }
        return $value;
    }

    public function getGalleryImagesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        $images = is_string($value) ? json_decode($value, true) : $value;
        if (!is_array($images)) {
            return [];
        }
        return array_map(function ($img) {
            if (is_string($img) && str_starts_with($img, '/storage/')) {
                return '/storage.php/' . substr($img, 9);
            }
            return $img;
        }, $images);
    }
}
