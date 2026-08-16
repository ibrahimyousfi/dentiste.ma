<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class Appointment extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'patient_id',
        'dentist_id',
        'room_id',
        'treatment_session_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'reminder_sent_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'reminder_sent_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }
}
