<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationUnit extends Model
{
    protected $table = 'organization_units';
    protected $guarded = [];
    public $timestamps = true;

    public function ugRegistrations()
    {
        return $this->hasMany(UgRegistration::class, 'org_unit_id');
    }

    public function gradStudents()
    {
        return $this->hasMany(GradStudent::class, 'org_unit_id');
    }
}
