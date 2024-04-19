<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncidentReport;
use Illuminate\Support\Facades\Validator;

class IncidentReportController extends Controller
{
    /**
     * Create an incident report.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|integer|exists:users,id',
            'provider_id' => 'required|integer|exists:healthcare_providers,id',
            'description' => 'required|string',
            'actions_taken' => 'required|string',
            'resolution' => 'required|string',
            'date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $incidentReport = IncidentReport::create($request->all());
        return response()->json($incidentReport, 201);
    }

    /**
     * List all incident reports involving a user.
     *
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $incidentReports = IncidentReport::where('patient_id', $userId)->get();
        return response()->json($incidentReports);
    }

    /**
     * Update details of an incident report.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $reportId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $reportId)
    {
        $incidentReport = IncidentReport::find($reportId);

        if (!$incidentReport) {
            return response()->json(['message' => 'Incident report not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'actions_taken' => 'required|string',
            'resolution' => 'required|string',
            'date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $incidentReport->update($request->all());
        return response()->json($incidentReport);
    }

    /**
     * Delete an incident report.
     *
     * @param int $reportId
     * @return \Illuminate\Http\Response
     */
    public function destroy($reportId)
    {
        $incidentReport = IncidentReport::find($reportId);

        if (!$incidentReport) {
            return response()->json(['message' => 'Incident report not found'], 404);
        }

        $incidentReport->delete();
        return response()->json(['message' => 'Incident report deleted successfully'], 200);
    }
}
