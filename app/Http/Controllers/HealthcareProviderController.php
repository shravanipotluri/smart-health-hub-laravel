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
}
