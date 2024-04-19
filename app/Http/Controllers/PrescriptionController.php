<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Prescription;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

// class PrescriptionController extends Controller
// {
//     public function index()
//     {
//         $prescriptions = Prescription::with(['user', 'healthcareProvider'])->get();
//         return response()->json($prescriptions);
//     }

//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'user_id' => 'required|integer|exists:users,id',
//             'healthcare_provider_id' => 'required|integer|exists:healthcare_providers,id', // Changed from users to healthcare_providers
//             'medication_name' => 'required|string',
//             'dosage' => 'required|string',
//             'frequency' => 'required|string',
//             'start_date' => 'required|date',
//             'end_date' => 'required|date',
//             'refills_remaining' => 'required|integer'
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         try {
//             $prescription = Prescription::create($request->all());
//             return response()->json($prescription, 201);
//         } catch (ModelNotFoundException $e) {
//             return response()->json(['message' => 'Healthcare provider not found'], 404);
//         }
//     }

//     public function show($id)
//     {
//         try {
//             $prescription = Prescription::with(['user', 'healthcareProvider'])->findOrFail($id);
//             return response()->json($prescription);
//         } catch (ModelNotFoundException $e) {
//             return response()->json(['message' => 'Prescription not found'], 404);
//         }
//     }

//     public function update(Request $request, $id)
//     {
//         try {
//             $prescription = Prescription::findOrFail($id);

//             $validator = Validator::make($request->all(), [
//                 'medication_name' => 'required|string',
//                 'dosage' => 'required|string',
//                 'frequency' => 'required|string',
//                 'start_date' => 'required|date',
//                 'end_date' => 'required|date',
//                 'refills_remaining' => 'required|integer'
//             ]);

//             if ($validator->fails()) {
//                 return response()->json($validator->errors(), 400);
//             }

//             $prescription->update($request->all());
//             return response()->json($prescription);
//         } catch (ModelNotFoundException $e) {
//             return response()->json(['message' => 'Prescription not found'], 404);
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $prescription = Prescription::findOrFail($id);
//             $prescription->delete();
//             return response()->json(['message' => 'Prescription deleted successfully']);
//         } catch (ModelNotFoundException $e) {
//             return response()->json(['message' => 'Prescription not found'], 404);
//         }
//     }
// }



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

    /**
     * Create a new prescription record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'healthcare_provider_id' => 'required|integer|exists:healthcare_providers,id',
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