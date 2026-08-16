<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BelongsToOrganization;

class Patient extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'branch_id',
        'patient_code',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'national_id',
        'address',
        'treatment_status',
        'total_sessions',
        'completed_sessions',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function notes()
    {
        return $this->hasMany(PatientNote::class)->orderBy('created_at', 'desc');
    }

    public function media()
    {
        return $this->hasMany(PatientMedia::class)->orderBy('taken_at', 'desc')->orderBy('created_at', 'desc');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderBy('created_at', 'desc');
    }
}
