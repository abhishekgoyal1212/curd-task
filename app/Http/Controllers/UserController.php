<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create($validatedData);
        $user->load('role');
        return response()->json($user, 201);
    }
}
