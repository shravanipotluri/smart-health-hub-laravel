<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
    
        // if (!$user || $user->password !== $validated['password']) {
        if (!$user || !Hash::check($validated['password'], $user->password)) {
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
        $users = User::all();
        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users
        ], 200);
    }

    public function getUsersByRole($role)
    {
        $users = User::where('role', $role)->get();

        return response()->json($users);
    }

    public function update(Request $request, $id)
    {
        // Retrieve the user by id
        $user = User::findOrFail($id);
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'role' => 'sometimes|string|in:Patient,Healthcare Provider,Administrator,Pharmacist,Health Administrator',
        ]);
    
        // Update the user with validated data
        $user->fill($validatedData);
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();
    
        // Return a JSON response on success
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }
    public function destroy($id)
    {
        // Retrieve the user by id and delete
        $user = User::findOrFail($id);
        $user->delete();
    
        // Return a JSON response on success
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }


}