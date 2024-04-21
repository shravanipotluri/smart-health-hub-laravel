<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Http\Resources\FacilityResource; 

class FacilityController extends Controller
{
    public function showAll()
    {
        return FacilityResource::collection(Facility::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'services' => 'required|string', 
            'status' => 'required|in:active,inactive',
        ]);

        $facility = Facility::create($validated);
        return new FacilityResource($facility);
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'services' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $facility->update($validated);
        return new FacilityResource($facility);
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return response()->json(['message' => 'Facility deleted successfully']);
    }
}
