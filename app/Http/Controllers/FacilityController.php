<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use Illuminate\Support\Facades\Validator;
class FacilityController extends Controller
{
    public function showAll()
    {
        $facility = Facility::all();
        return response()->json($facility);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'services' => 'required|string', 
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $facility = Facility::create($request->all());
        return response()->json($facility, 201);
    }

    public function update(Request $request, Facility $facility)
    {
        if (!$facility) {
            return response()->json(['message' => 'facility not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'services' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $facility->update($request->all());
        return response()->json($facility);
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return response()->json(['message' => 'Facility deleted successfully']);
    }
}
