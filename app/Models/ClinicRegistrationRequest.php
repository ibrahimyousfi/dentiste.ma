<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicRegistrationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_name',
        'owner_name',
        'email',
        'phone',
        'status',
        'notes',
    ];
}
