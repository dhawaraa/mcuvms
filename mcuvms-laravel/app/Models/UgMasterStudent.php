<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UgMasterStudent extends Model
{
    protected $table = 'ug_master_students';
    protected $guarded = [];

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function registrations()
    {
        return $this->hasMany(UgRegistration::class, 'student_code', 'student_code');
    }
}
