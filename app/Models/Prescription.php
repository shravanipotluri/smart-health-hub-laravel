<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacist_id', 'healthcare_provider_id', 'user_email', 'medication_name', 'dosage', 'frequency', 'start_date', 'end_date', 'refills_remaining',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthcareProvider()
    {
        return $this->belongsTo(User::class, 'healthcare_provider_id');
    }
}
