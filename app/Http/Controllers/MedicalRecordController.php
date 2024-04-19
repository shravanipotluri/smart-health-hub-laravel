<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\MedicalRecord; 
// use Illuminate\Support\Facades\Validator;

// class MedicalRecordController extends Controller
// {
//     /**
//      * Display a listing of medical records.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         $records = MedicalRecord::all();
//         return response()->json($records);
//     }

//     /**
//      * Store a newly created medical record in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'user_id' => 'required|integer|exists:users,id',
//             'allergies' => 'required|json',
//             'conditions' => 'required|json',
//             'surgeries' => 'nullable|json',
//             'family_history' => 'nullable|json',
//             'blood_group' => 'nullable|string',
//             'lifestyle' => 'nullable|string',
//             'emergency_contact' => 'nullable|string',
//             // Add other fields as necessary
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         $record = MedicalRecord::create($request->all());
//         return response()->json($record, 201);
//     }

//     /**
//      * Display the specified medical record.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         $record = MedicalRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }
//         return response()->json($record);
//     }

//     /**
//      * Update the specified medical record in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         $record = MedicalRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }

//         $validator = Validator::make($request->all(), [
//             'allergies' => 'required|json',
//             'conditions' => 'required|json',
//             'surgeries' => 'nullable|json',
//             'family_history' => 'nullable|json',
//             'blood_group' => 'nullable|string',
//             'lifestyle' => 'nullable|string',
//             'emergency_contact' => 'nullable|string',
//             // Define validation for other fields
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         $record->update($request->all());
//         return response()->json($record);
//     }

//     /**
//      * Remove the specified medical record from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $record = MedicalRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }
//         $record->delete();
//         return response()->json(['message' => 'Record deleted successfully']);
//     }
// }



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

    /**
     * Create a new medical record entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'medical_history' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'appointments' => 'nullable|string',
            'allergies' => 'nullable|string',
            'immunizations' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'lab_results' => 'nullable|string',
            // Add other fields as necessary
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalRecord = MedicalRecord::create($request->all());
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
            // Add other fields as necessary
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
