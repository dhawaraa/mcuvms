<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationUnit extends Model
{
    protected $table = 'organization_units';
    protected $guarded = [];
    public $timestamps = false;

    public function scopeOrderedForSelect($query)
    {
        return $query->where('is_active', 1)
            ->orderByRaw("CASE WHEN name_th LIKE '%สถาบันวิปัสสนาธุระ%' OR code = 'MCU-VIPASSANA' THEN 0 ELSE 1 END")
            ->orderBy('id', 'asc');
    }

    public function ugRegistrations()
    {
        return $this->hasMany(UgRegistration::class, 'org_unit_id');
    }

    public function gradStudents()
    {
        return $this->hasMany(GradStudent::class, 'org_unit_id');
    }

    public function getLocalizedNameAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->name_en)) {
            return $this->name_en;
        }
        return $this->name_th;
    }
}
