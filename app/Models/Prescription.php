<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'healthcare_provider_id', 'medication_name', 'dosage', 'frequency', 'start_date', 'end_date', 'refills_remaining'
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
