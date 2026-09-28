<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradCreditEntry extends Model
{
    protected $table = 'grad_credit_entries';
    protected $guarded = [];
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(GradStudent::class, 'student_id');
    }
}
