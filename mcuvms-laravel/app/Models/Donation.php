<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $guarded = [];

    protected $casts = [
        'is_tax_deductible' => 'boolean',
        'amount' => 'decimal:2',
        'transfer_date' => 'date',
        'verified_at' => 'datetime',
    ];

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
