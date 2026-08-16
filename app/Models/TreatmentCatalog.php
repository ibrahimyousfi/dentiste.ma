<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentCatalog extends Model
{
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'treatment_inventory')
                    ->withPivot('quantity_consumed')
                    ->withTimestamps();
    }
}
