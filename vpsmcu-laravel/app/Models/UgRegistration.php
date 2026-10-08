<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UgRegistration extends Model
{
    protected $table = 'ug_registrations';
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(UgBatch::class, 'batch_id');
    }

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }
}
