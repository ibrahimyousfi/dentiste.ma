<?php

namespace App\Traits;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToOrganization
{
    /**
     * Boot the trait and apply the global scope.
     */
    protected static function bootBelongsToOrganization()
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            // Check if user is authenticated and is NOT a Super Admin
            if (Auth::hasUser()) {
                $user = Auth::user();
                if (! method_exists($user, 'hasRole') || ! $user->hasRole('Super Admin')) {
                    $builder->where('organization_id', $user->organization_id ?? 1);
                }
            }
        });

        // Automatically set the organization_id when creating new records
        static::creating(function ($model) {
            if (Auth::hasUser() && empty($model->organization_id)) {
                $user = Auth::user();
                if (! method_exists($user, 'hasRole') || ! $user->hasRole('Super Admin')) {
                    $model->organization_id = $user->organization_id ?? 1;
                }
            }
        });
    }

    /**
     * Relationship: The model belongs to an Organization.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
