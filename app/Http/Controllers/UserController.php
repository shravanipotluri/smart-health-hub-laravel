<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15', 
            'role' => 'required|string|in:Patient,Healthcare Provider,Administrator,Pharmacist,Health Administrator',
        ]);

        try {
            // Create and save the new user
            $user = new User([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'], 
                'date_of_birth' => $validatedData['date_of_birth'],
                'address' => $validatedData['address'],
                'phone_number' => $validatedData['phone_number'],
                'role' => $validatedData['role'],
            ]);
            $user->save();

            // Return a JSON response on success
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'error' => 'Registration failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $validated['email'])->first();
    
        if (!$user || $user->password !== $validated['password']) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        return response()->json(['message' => 'Login successful', 'user' => $user]);
    }
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = \Str::random(60);
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Implement email sending...

        return response()->json(['message' => 'Reset password link sent to your email address']);
    }


    public function getAllUsers()
    {
        $users = User::all(['id', 'role', 'name']); 
        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users
        ], 200);
    }




}