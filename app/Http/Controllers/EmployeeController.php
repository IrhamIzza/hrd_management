<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'karyawan')
            ->where('approval_status', 'approved')
            ->latest()
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' =>'required',
            'phone' => 'required',
            'departement' => 'required',
            'profile_photo' => 'nullable|image|max:1024',
            'email_active' => 'nullable|email',
            'birth_date' => 'nullable|date',
            'nip' => 'nullable|string',
            'home_address' => 'nullable|string',
            'work_address' => 'nullable|string',
            'position' => 'nullable|string',
            'join_date' => 'nullable|date',
            'employment_status' => 'nullable|in:tetap,kontrak',
            'contract_duration' => 'nullable|integer|min:1',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['approval_status'] = 'approved';

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }


        $user = User::create($data);
        $user->calculateWorkDuration();
        // $user->calculateWorkDetails();

        if ($request->hasFile('ijazah')) {
            $path = $request->file('ijazah')->store('documents', 'public');
            $user->ijazah = $path;
        }
        if ($request->hasFile('sip')) {
            $path = $request->file('sip')->store('documents', 'public');
            $user->sip = $path;
        }
        if ($request->hasFile('kk')) {
            $path = $request->file('kk')->store('documents', 'public');
            $user->kk = $path;
        }
        if ($request->hasFile('ktp')) {
            $path = $request->file('ktp')->store('documents', 'public');
            $user->ktp = $path;
        }
        $user->save(); // Simpan perubahan dokumen

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $editableFields = $employee->getEditableFields();
        $validationRules = [];

        // Add validation rules for editable fields
        foreach ($editableFields as $field) {
            switch ($field) {
                case 'name':
                    $validationRules[$field] = 'required|string|max:255';
                    break;
                case 'username':
                    $validationRules[$field] = 'required|string|max:255|unique:users,username,' . $employee->id;
                    break;
                case 'email':
                    $validationRules[$field] = 'required|email|max:255|unique:users,email,' . $employee->id;
                    break;
                case 'email_active':
                    $validationRules[$field] = 'nullable|email|max:255';
                    break;
                case 'phone':
                    $validationRules[$field] = 'required|string|max:20';
                    break;
                case 'departement':
                    $validationRules[$field] = 'required|string|max:100';
                    break;
                case 'profile_photo':
                    $validationRules[$field] = 'nullable|image|max:1024';
                    break;
                case 'birth_date':
                    $validationRules[$field] = 'nullable|date';
                    break;
                case 'nip':
                    $validationRules[$field] = 'nullable|string|max:50';
                    break;
                case 'home_address':
                case 'work_address':
                    $validationRules[$field] = 'nullable|string';
                    break;
                case 'role':
                    $validationRules[$field] = 'required|in:hrd,karyawan';
                    break;
                case 'position':
                    $validationRules[$field] = 'nullable|string|max:100';
                    break;
                case 'employment_status':
                    $validationRules[$field] = 'nullable|in:tetap,kontrak';
                    break;
                case 'contract_duration':
                    $validationRules[$field] = 'nullable|integer|min:1';
                    break;
            }
        }

        $request->validate($validationRules);

        $data = $request->only($editableFields);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($employee->profile_photo) {
                Storage::disk('public')->delete($employee->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $employee->update($data);
        $employee->calculateWorkDuration();
        // $employee->calculateWorkDetails();

        return redirect()->route('employees.index')->with('success', 'Data karyawan diperbarui.');
    }

    public function destroy(User $employee)
    {
        if ($employee->profile_photo) {
            Storage::disk('public')->delete($employee->profile_photo);
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan dihapus.');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }
}
