<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UgBatch extends Model
{
    protected $table = 'ug_batches';
    protected $guarded = [];

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }

    public function registrations()
    {
        return $this->hasMany(UgRegistration::class, 'batch_id');
    }
}
