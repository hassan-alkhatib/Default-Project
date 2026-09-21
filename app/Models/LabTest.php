<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_number',
        'patient_id',
        'doctor_id',
        'medical_record_id',
        'test_type',
        'test_name',
        'description',
        'test_date',
        'result_date',
        'results',
        'reference_range',
        'status',
        'urgency',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'test_date' => 'date',
            'result_date' => 'date',
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

    public static function generateTestNumber(): string
    {
        $last = self::latest('id')->first();
        $number = $last ? intval(substr($last->test_number, 3)) + 1 : 1;
        return 'LAB' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
