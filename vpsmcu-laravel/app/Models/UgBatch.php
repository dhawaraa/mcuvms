<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UgBatch extends Model
{
    protected $table = 'ug_batches';
    protected $guarded = [];
    public $timestamps = false;

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function registrations()
    {
        return $this->hasMany(UgRegistration::class, 'batch_id');
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
        if (app()->getLocale() === 'en' && !empty($this->location_en)) {
            return $this->location_en;
        }
        return $this->location;
    }

    public function getCoverImageAttribute($value)
    {
        if (!empty($value) && str_starts_with($value, '/storage/')) {
            return '/storage.php/' . substr($value, 9);
        }
        return $value;
    }
}
