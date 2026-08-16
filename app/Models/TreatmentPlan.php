<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function sessions()
    {
        return $this->hasMany(TreatmentSession::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAmountPaidAttribute()
    {
        return $this->invoices()->sum('paid_amount');
    }
}
