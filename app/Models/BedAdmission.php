<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BedAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'room_id',
        'doctor_id',
        'admission_date',
        'expected_discharge_date',
        'actual_discharge_date',
        'reason',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'expected_discharge_date' => 'date',
            'actual_discharge_date' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
