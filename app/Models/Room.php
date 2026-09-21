<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'department_id',
        'type',
        'capacity',
        'current_occupancy',
        'rate_per_day',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'current_occupancy' => 'integer',
            'rate_per_day' => 'decimal:2',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function bedAdmissions(): HasMany
    {
        return $this->hasMany(BedAdmission::class);
    }

    public function getAvailableBedsAttribute(): int
    {
        return $this->capacity - $this->current_occupancy;
    }

    public function updateStatus(): void
    {
        if ($this->current_occupancy >= $this->capacity) {
            $this->status = 'occupied';
        } elseif ($this->current_occupancy > 0) {
            $this->status = $this->status === 'maintenance' ? $this->status : 'occupied';
        } else {
            $this->status = $this->status === 'maintenance' ? 'maintenance' : 'available';
        }
        $this->save();
    }
}
