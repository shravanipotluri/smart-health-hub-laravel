<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    /**
     * Retrieve all medical records for a user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $medicalRecords = MedicalRecord::where('user_id', $userId)->get();
        return response()->json($medicalRecords);
    }
    public function hpIndex()
    {
        $medicalRecords = MedicalRecord::all();
        return response()->json($medicalRecords);
    }

    /**
     * Create a new medical record entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'medical_history' => 'required',
        'prescriptions' => 'required',
        'appointments' => 'required',
        'allergies' => 'required',
        'blood_group' => 'required',
        'blood_pressure' => 'nullable|string',
        'conditions' => 'required',
        'emergency_contact' => 'required',
        'family_history' => 'required',
        'immunizations' => 'required',
        'lab_results' => 'required',
        'lifestyle' => 'required',
        'surgeries' => 'required',
        'vital_signs' => 'required',
    ]);

    $medicalRecord = new MedicalRecord([
        'user_id' => $request->get('user_id'),
        'medical_history' => $request->get('medical_history'),
        'prescriptions' => $request->get('prescriptions'),
        'appointments' => $request->get('appointments'),
        'allergies' => $request->get('allergies'),
        'blood_group' => $request->get('blood_group'),
        'conditions' => $request->get('conditions'),
        'emergency_contact' => $request->get('emergency_contact'),
        'family_history' => $request->get('family_history'),
        'immunizations' => $request->get('immunizations'),
        'lab_results' => $request->get('lab_results'),
        'lifestyle' => $request->get('lifestyle'),
        'surgeries' => $request->get('surgeries'),
        'vital_signs' => $request->get('vital_signs'),
    ]);

    $medicalRecord->save();

    return response()->json($medicalRecord, 201);
}
    /**
     * Update an existing medical record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $recordId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $recordId)
    {
        $medicalRecord = MedicalRecord::find($recordId);

        if (!$medicalRecord) {
            return response()->json(['message' => 'Medical record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'medical_history' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'appointments' => 'nullable|string',
            'allergies' => 'nullable|string',
            'immunizations' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'lab_results' => 'nullable|string',
            'lifestyle' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'family_history' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'conditions' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalRecord->update($request->all());
        return response()->json($medicalRecord);
    }

    /**
     * Remove a medical record.
     *
     * @param  int  $recordId
     * @return \Illuminate\Http\Response
     */
    public function destroy($recordId)
    {
        $medicalRecord = MedicalRecord::find($recordId);

        if (!$medicalRecord) {
            return response()->json(['message' => 'Medical record not found'], 404);
        }

        $medicalRecord->delete();
        return response()->json(['message' => 'Medical record deleted successfully'], 200);
    }
}
