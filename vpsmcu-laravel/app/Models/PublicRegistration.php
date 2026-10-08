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

    public function getLocalizedDietaryAttribute()
    {
        $map = [
            'NORMAL' => __('portal.public_food_normal'),
            'VEGETARIAN' => __('portal.public_food_veg'),
            'JAY' => __('portal.public_food_jay'),
            'HALAL' => __('portal.public_food_halal'),
        ];
        return $map[$this->dietary_restriction] ?? ($this->dietary_restriction ?: __('portal.public_food_normal'));
    }
}
