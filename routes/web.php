<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Role;    
use App\Models\user;    

Route::get('/', function () {
    $roles = Role::all();
    $user = user::with('role')->orderBy('id', 'DESC')->get();
    return view('welcome', compact('roles','user'));   
});

Route::post('/users', [UserController::class, 'store'])->name('saveData');
