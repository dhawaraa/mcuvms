<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicEvent extends Model
{
    protected $table = 'public_events';
    protected $guarded = [];
    public $timestamps = false;

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function registrations()
    {
        return $this->hasMany(PublicRegistration::class, 'event_id');
    }

    public function getLocalizedTitleAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        return $this->title;
    }

    public function getLocalizedLocationAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->location_name_en)) {
            return $this->location_name_en;
        }
        return $this->location_name;
    }

    public function getCoverImageAttribute($value)
    {
        if (!empty($value) && str_starts_with($value, '/storage/')) {
            return '/storage.php/' . substr($value, 9);
        }
        return $value;
    }
}
