<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'org_unit_id',
        'username',
        'password_hash',
        'full_name',
        'email',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function organizationUnit()
    {
        return $this->belongsTo(OrganizationUnit::class, 'org_unit_id');
    }
}

