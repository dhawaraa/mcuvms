<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicRegistration extends Model
{
    protected $table = 'public_registrations';
    protected $guarded = [];
    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(PublicEvent::class, 'event_id');
    }

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }
}
