<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $guarded = [];

    public static function get($key, $default = null)
    {
        $item = static::where('setting_key', $key)->first();
        return $item ? $item->setting_value : $default;
    }

    public static function set($key, $value, $group = 'general', $label = null, $type = 'text')
    {
        return static::updateOrInsert(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'setting_group' => $group,
                'label' => $label,
                'field_type' => $type,
                'updated_at' => now(),
            ]
        );
    }

    public static function getByGroup($group)
    {
        return static::where('setting_group', $group)->pluck('setting_value', 'setting_key')->toArray();
    }
}
