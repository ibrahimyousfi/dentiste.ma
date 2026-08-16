<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'organization_id', 'name', 'category', 'current_stock', 
        'minimum_stock', 'unit', 'cost_per_unit'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function treatments()
    {
        return $this->belongsToMany(TreatmentCatalog::class, 'treatment_inventory')
                    ->withPivot('quantity_consumed')
                    ->withTimestamps();
    }
}
