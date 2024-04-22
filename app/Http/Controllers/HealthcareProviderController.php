<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthcareProvider;

class HealthcareProviderController extends Controller
{
    public function store(Request $request) {
        $provider = new HealthcareProvider();
        $provider->name = $request->name;
        $provider->address = $request->address;
        $provider->phone = $request->phone;
        $provider->save();
        return response()->json($provider, 201);
    }
    public function getAllProviders() {
        $providers = HealthcareProvider::all();
        return response()->json($providers, 200);
    }
    public function getProvider($userId){
        $providerDetails = HealthcareProvider::where('user_id', $userId)->get();
            return response()->json($providerDetails);
    }
    public function update(Request $request, $id) {
        $provider = HealthcareProvider::find($id);
    
        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }
    
        $provider->provider_name = $request->get('provider_name', $provider->provider_name);
        $provider->specialty = $request->get('specialty', $provider->specialty);
        $provider->location = $request->get('location', $provider->location);
        $provider->rating = $request->get('rating', $provider->rating);

    
        $provider->save();
    
        return response()->json($provider, 200);
    }

    public function destroy($id) {
        $provider = HealthcareProvider::find($id);
    
        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }
    
        $provider->delete();
    
        return response()->json(['message' => 'Provider deleted'], 200);
    }
}
