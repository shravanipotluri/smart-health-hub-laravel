<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\MedicationDispensationRecord;

// class MedicationDispensationRecordController extends Controller
// {
//     public function index()
//     {
//         $records = MedicationDispensationRecord::all();
//         return response()->json($records);
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'patient_id' => 'required|integer|exists:users,id',
//             'medication' => 'required|string',
//             'dosage' => 'required|string',
//             'date_dispensed' => 'required|date'
//         ]);

//         $record = MedicationDispensationRecord::create($request->all());
//         return response()->json($record, 201);
//     }

//     public function show($id)
//     {
//         $record = MedicationDispensationRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }
//         return response()->json($record);
//     }

//     public function update(Request $request, $id)
//     {
//         $record = MedicationDispensationRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }

//         $request->validate([
//             'patient_id' => 'required|integer|exists:users,id',
//             'medication' => 'required|string',
//             'dosage' => 'required|string',
//             'date_dispensed' => 'required|date'
//         ]);

//         $record->update($request->all());
//         return response()->json($record);
//     }

//     public function destroy($id)
//     {
//         $record = MedicationDispensationRecord::find($id);
//         if (!$record) {
//             return response()->json(['message' => 'Record not found'], 404);
//         }
//         $record->delete();
//         return response()->json(['message' => 'Record deleted successfully']);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationDispensationRecord;
use Illuminate\Support\Facades\Validator;

class MedicationDispensationRecordController extends Controller
{
    /**
     * Log dispensation of medication.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|integer|exists:users,id',
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'date_dispensed' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $record = MedicationDispensationRecord::create($request->all());
        return response()->json($record, 201);
    }

    /**
     * Retrieve all dispensation records for a patient.
     *
     * @param int $patientId
     * @return \Illuminate\Http\Response
     */
    public function index($patientId)
    {
        $records = MedicationDispensationRecord::where('patient_id', $patientId)->get();
        return response()->json($records);
    }

    /**
     * Update a dispensation record.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $recordId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $recordId)
    {
        $record = MedicationDispensationRecord::find($recordId);

        if (!$record) {
            return response()->json(['message' => 'Dispensation record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'date_dispensed' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $record->update($request->all());
        return response()->json($record);
    }

    /**
     * Remove a dispensation record.
     *
     * @param int $recordId
     * @return \Illuminate\Http\Response
     */
    public function destroy($recordId)
    {
        $record = MedicationDispensationRecord::find($recordId);

        if (!$record) {
            return response()->json(['message' => 'Dispensation record not found'], 404);
        }

        $record->delete();
        return response()->json(['message' => 'Dispensation record deleted successfully'], 200);
    }
}