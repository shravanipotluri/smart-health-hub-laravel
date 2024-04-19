<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationDispensationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'medication', 'dosage', 'date_dispensed'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
