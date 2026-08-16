<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToothFinding extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'surfaces' => 'array',
        'treatments' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
