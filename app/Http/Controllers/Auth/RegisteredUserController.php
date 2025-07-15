<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_active' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'departement' => ['required', 'string', 'max:100'],
            'profile_photo' => ['nullable', 'image', 'max:1024'],
            'birth_date' => ['nullable', 'date'],
            'nip' => ['nullable', 'string', 'max:50'],
            'home_address' => ['nullable', 'string'],
            'work_address' => ['nullable', 'string'],
            'join_date' => ['nullable', 'date'],
            'role' => ['required', 'in:hrd,karyawan'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user data array with all fields
        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'email_active' => $request->email_active,
            'phone' => $request->phone,
            'departement' => $request->departement,
            'birth_date' => $request->birth_date,
            'nip' => $request->nip,
            'home_address' => $request->home_address,
            'work_address' => $request->work_address,
            'join_date' => $request->join_date,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'approval_status' => 'pending',
            // 'position' => '',
            // 'employment_status' => '',
            // 'contract_duration' => '',
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $userData['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Create the user
        $user = User::create($userData);

        // Redirect to login with success message
        return redirect()->route('login')
            ->with('status', 'Registrasi berhasil! Silakan tunggu persetujuan dari HRD untuk dapat mengakses sistem.');
    }
} 