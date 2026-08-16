<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'organization_id',
        'patient_id',
        'treatment_session_id',
        'invoice_number',
        'total_amount',
        'paid_amount',
        'status',
        'due_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
