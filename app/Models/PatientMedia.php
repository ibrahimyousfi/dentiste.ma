<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedia extends Model
{
    protected $fillable = [
        'patient_id',
        'file_path',
        'file_name',
        'file_type',
        'category',
        'notes',
        'taken_at'
    ];

    protected $casts = [
        'taken_at' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }}
