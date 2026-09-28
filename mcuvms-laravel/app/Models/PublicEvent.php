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
}
