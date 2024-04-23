<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function show($id)
    {
        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance not found'], 404);
        }
        return response()->json($maintenance);
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance not found'], 404);
        }

        $maintenance->update($request->all());
        return response()->json(['message' => 'Maintenance updated successfully', 'data' => $maintenance]);
    }
}