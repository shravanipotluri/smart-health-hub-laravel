<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    /**
     * Retrieve all prescriptions for a user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $prescriptions = Prescription::where('user_id', $userId)->get();
        return response()->json($prescriptions);
    }
    public function emailIndex($userEmail)
    {
        $prescriptions = Prescription::where('user_email', $userEmail)->get();
        return response()->json($prescriptions);
    }
    public function getAllPrescriptions()
    {
        $prescriptions = Prescription::all();
        return response()->json($prescriptions);
    }

    public function hpindex($hpId)
    {
        $prescriptions = Prescription::where('healthcare_provider_id', $hpId)->get();
        return response()->json($prescriptions);
    }

    /**
     * Create a new prescription record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pharmacist_id' => 'required|integer|exists:users,id',
            'healthcare_provider_id' => 'required|integer|exists:healthcare_providers,id',
            'user_email' => 'required|string|exists:users,email',
            'medication_name' => 'required|string',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'refills_remaining' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $prescription = Prescription::create($request->all());
        return response()->json($prescription, 201);
    }

    /**
     * Update prescription details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $prescriptionId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $prescriptionId)
    {
        $prescription = Prescription::find($prescriptionId);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        $validator = Validator::make($request->all(), [

            'dispense' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $prescription->update($request->all());
        return response()->json($prescription);
    }

    /**
     * Delete a prescription.
     *
     * @param  int  $prescriptionId
     * @return \Illuminate\Http\Response
     */
    public function destroy($prescriptionId)
    {
        $prescription = Prescription::find($prescriptionId);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        $prescription->delete();
        return response()->json(['message' => 'Prescription deleted successfully'], 200);
    }
}