<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_number',
        'patient_id',
        'doctor_id',
        'medical_record_id',
        'prescription_date',
        'valid_until',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'prescription_date' => 'date',
            'valid_until' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public static function generatePrescriptionNumber(): string
    {
        $last = self::latest('id')->first();
        $number = $last ? intval(substr($last->prescription_number, 3)) + 1 : 1;
        return 'RX' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
