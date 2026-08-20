<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'subscription_plan',
        'subscription_status',
        'subscription_ends_at',
        'logo',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latest('id');
    }

    public function allSubscriptions()
    {
        return $this->hasMany(Subscription::class)->orderBy('starts_at', 'desc');
    }

    public function hasFeature($featureKey)
    {
        $sub = $this->subscription;
        if (!$sub || !$sub->plan) return false;
        
        $features = $sub->plan->features ?? [];
        return isset($features[$featureKey]) && $features[$featureKey] === true;
    }

    public function canAddMorePatients()
    {
        $sub = $this->subscription;
        if (!$sub || !$sub->plan) return false;

        $limit = $sub->plan->limit_patients;
        if (is_null($limit)) return true; // Unlimited

        // Check total created including soft deleted to prevent abuse
        $currentCount = $this->patients()->withTrashed()->count();
        return $currentCount < $limit;
    }

    public function canAddMoreUsers()
    {
        $sub = $this->subscription;
        if (!$sub || !$sub->plan) return false;

        $limit = $sub->plan->limit_users;
        if (is_null($limit)) return true; // Unlimited

        $currentCount = $this->users()->count();
        return $currentCount < $limit;
    }
}
