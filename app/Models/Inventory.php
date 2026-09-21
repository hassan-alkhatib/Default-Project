<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'item_code',
        'name',
        'name_ar',
        'category',
        'description',
        'quantity',
        'minimum_stock',
        'maximum_stock',
        'unit_price',
        'supplier',
        'supplier_phone',
        'expiry_date',
        'location',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'minimum_stock' => 'integer',
            'maximum_stock' => 'integer',
            'unit_price' => 'decimal:2',
            'expiry_date' => 'date',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function updateStatus(): void
    {
        if ($this->quantity <= 0) {
            $this->status = 'out_of_stock';
        } elseif ($this->quantity <= $this->minimum_stock) {
            $this->status = 'low_stock';
        } elseif ($this->expiry_date && $this->expiry_date->isPast()) {
            $this->status = 'expired';
        } else {
            $this->status = 'in_stock';
        }
        $this->save();
    }
}
