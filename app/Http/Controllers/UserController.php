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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:15', 
                'role' => 'required|string|in:Patient,Healthcare Provider,Administrator,Pharmacist,Health Administrator',
            ]);
    
            $user = new User($validatedData);
            $user->save();
    
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Registration failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
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
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);
    
        $user = User::where('email', $validated['email'])->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->password = $validated['password'];
        $user->save();
    
        return response()->json([
            'message' => 'Password updated successfully'
        ], 200);
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