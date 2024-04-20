<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Appointment;
// use Illuminate\Support\Facades\Validator;

// class AppointmentController extends Controller
// {
//     public function index()
//     {
//         $appointments = Appointment::with(['user', 'healthcareProvider'])->get();
//         return response()->json($appointments);
//     }

//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'user_id' => 'required|integer|exists:users,id',
//             'healthcare_provider_id' => 'required|integer|exists:users,id',
//             'date' => 'required|date',
//             'time' => 'required|date_format:H:i',
//             'location' => 'required|string',
//             'status' => 'required|in:Scheduled,Rescheduled,Canceled'
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         $appointment = Appointment::create($request->all());
//         return response()->json($appointment, 201);
//     }

//     public function show($id)
//     {
//         $appointment = Appointment::with(['user', 'healthcareProvider'])->find($id);
//         if (!$appointment) {
//             return response()->json(['message' => 'Appointment not found'], 404);
//         }
//         return response()->json($appointment);
//     }

//     public function update(Request $request, $id)
//     {
//         $appointment = Appointment::find($id);
//         if (!$appointment) {
//             return response()->json(['message' => 'Appointment not found'], 404);
//         }

//         $validator = Validator::make($request->all(), [
//             'date' => 'required|date',
//             'time' => 'required|date_format:H:i',
//             'location' => 'required|string',
//             'status' => 'required|in:Scheduled,Rescheduled,Canceled'
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 400);
//         }

//         $appointment->update($request->all());
//         return response()->json($appointment);
//     }

//     public function destroy($id)
//     {
//         $appointment = Appointment::find($id);
//         if (!$appointment) {
//             return response()->json(['message' => 'Appointment not found'], 404);
//         }
//         $appointment->delete();
//         return response()->json(['message' => 'Appointment deleted successfully']);
//     }
// }



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Get all appointments for a user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $appointments = Appointment::where('user_id', $userId)->get();
        return response()->json($appointments);
    }
    public function hpindex($hpId)
    {
        $appointments = Appointment::where('healthcare_provider_id', $hpId)->get();
        return response()->json($appointments);
    }

    /**
     * Create a new appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'healthcare_provider_id' => 'required|integer|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'status' => 'required|in:Scheduled,Rescheduled,Canceled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $appointment = Appointment::create($request->all());
        return response()->json($appointment, 201);
    }

    /**
     * Update details of an appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $appointmentId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'status' => 'required|in:Scheduled,Rescheduled,Canceled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $appointment->update($request->all());
        return response()->json($appointment);
    }

    /**
     * Cancel an existing appointment.
     *
     * @param  int  $appointmentId
     * @return \Illuminate\Http\Response
     */
    public function destroy($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete();
        return response()->json(['message' => 'Appointment canceled successfully']);
    }
}
