<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabCase extends Model
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

    public function labPartner()
    {
        return $this->belongsTo(LabPartner::class);
    }
}
