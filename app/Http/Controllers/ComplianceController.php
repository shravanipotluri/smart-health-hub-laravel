<?php
namespace App\Http\Controllers;

use App\Models\Compliance;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    public function showAll()
    {
        return response()->json(Compliance::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Compliant,Pending Review,Non-Compliant',
        ]);

        $compliance = Compliance::create($validated);
        return response()->json($compliance);  // Using JSON response directly
    }

    public function update(Request $request, Compliance $compliance)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'required|in:Compliant,Pending Review,Non-Compliant',
        ]);

        $compliance->update($validatedData);
        return response()->json(['message' => 'Compliance status updated successfully', 'compliance' => $compliance]);
    }

    public function destroy(Compliance $compliance)
    {
        $compliance->delete();
        return response()->json(['message' => 'Compliance data deleted successfully']);
    }
}
