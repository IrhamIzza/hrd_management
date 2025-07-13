<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): RedirectResponse
    {
        Validator::make($input, [
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
            'role' => ['required', 'in:karyawan'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Create user data array with all fields
        $userData = [
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'email_active' => $input['email_active'] ?? null,
            'phone' => $input['phone'],
            'departement' => $input['departement'],
            'birth_date' => $input['birth_date'] ?? null,
            'nip' => $input['nip'] ?? null,
            'home_address' => $input['home_address'] ?? null,
            'work_address' => $input['work_address'] ?? null,
            'join_date' => $input['join_date'] ?? null,
            'role' => $input['role'],
            'password' => Hash::make($input['password']),
            'approval_status' => 'pending',
        ];

        // Handle profile photo upload
        if (isset($input['profile_photo'])) {
            $userData['profile_photo'] = $input['profile_photo']->store('profile-photos', 'public');
        }

        // Create the user
        $user = User::create($userData);

        // Notify HRD users about new registration
        $hrUsers = User::where('role', 'hrd')->get();
        foreach ($hrUsers as $hrUser) {
            DB::table('notifications')->insert([
                'user_id' => $hrUser->id,
                'type' => 'user_approval',
                'title' => 'Pengguna Baru Menunggu Persetujuan',
                'message' => "{$user->name} telah mendaftar dan menunggu persetujuan Anda.",
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "<script>alert('Registrasi berhasil! Silakan tunggu persetujuan dari HRD.')</script>";
        echo "<script>window.location.href = '/login'</script>";

    }
}
