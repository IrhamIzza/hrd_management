<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validationRules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'email_active' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'departement' => 'required|string|max:100',
            'profile_photo' => 'nullable|image|max:1024',
            'birth_date' => 'nullable|date',
            'nip' => 'nullable|string|max:50',
            'home_address' => 'nullable|string',
            'work_address' => 'nullable|string',
            'join_date' => 'nullable|date',
            'password' => 'nullable|min:6',


            'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $request->validate($validationRules);

        $data = $request->except('password');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $file = $request->file('profile_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'pp_' .($user->username). '.'. $extension;
            // $file->storeAs('profile-photos',$filename, 'public');
            $data['profile_photo'] = $request->file('profile_photo')->storeAs('profile-photos',$filename, 'public');
        }

        // Upload dokumen-dokumen
        $documentFields = ['ijazah', 'sip', 'kk', 'ktp'];
        $uploadMessages = [];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($user->$field) {
                    Storage::disk('public')->delete($user->$field);
                }

                $path = $request->file($field)->store("documents/{$field}", 'public');

                if ($path) {
                    $data[$field] = $path;
                    $uploadMessages[] = ucfirst($field) . ' berhasil diunggah.';
                } else {
                    $uploadMessages[] = 'Gagal mengunggah ' . $field . '.';
                }
            }
        }



        $user->update($data);

        $mainMessage = 'Profil berhasil diperbarui.';
        $fullMessage = $mainMessage . ' ' . implode(' ', $uploadMessages);

        return redirect()->route('profile.edit')->with('success', $fullMessage);
    }
}
