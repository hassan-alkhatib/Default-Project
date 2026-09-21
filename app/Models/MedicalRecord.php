<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_number',
        'patient_id',
        'doctor_id',
        'appointment_id',
        'type',
        'visit_date',
        'chief_complaint',
        'diagnosis',
        'treatment_plan',
        'notes',
        'temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'weight',
        'height',
        'blood_sugar',
        'attachment_path',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'temperature' => 'decimal:1',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
            'blood_sugar' => 'decimal:1',
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

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public static function generateRecordNumber(): string
    {
        $last = self::latest('id')->first();
        $number = $last ? intval(substr($last->record_number, 3)) + 1 : 1;
        return 'MR' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
