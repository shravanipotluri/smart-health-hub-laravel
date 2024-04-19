<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'description', 'patient_id', 'provider_id', 'actions_taken', 'resolution'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function provider()
    {
        return $this->belongsTo(HealthcareProvider::class, 'provider_id');
    }
}
