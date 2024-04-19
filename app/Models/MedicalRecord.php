<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'medical_history', 'prescriptions', 'appointments', 'allergies', 'immunizations', 
        'vital_signs', 'lab_results', 'surgeries', 'family_history', 'blood_group', 'lifestyle', 
        'emergency_contact', 'conditions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
