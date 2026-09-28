<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradStudent extends Model
{
    protected $table = 'grad_students';
    protected $guarded = [];
    public $timestamps = false;

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function creditEntries()
    {
        return $this->hasMany(GradCreditEntry::class, 'student_id');
    }
}
