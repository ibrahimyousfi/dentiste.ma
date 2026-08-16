<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentSession extends Model
{
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(TreatmentPlan::class, 'treatment_plan_id');
    }
}
