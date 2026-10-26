<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.login-register', ['activeTab' => 'register']);
    }

    public function store(Request $request): RedirectResponse
    {
        $rawRole = $request->input('role_type', 'siswa');
        $roleType = in_array($rawRole, ['guru', 'staf', 'pegawai']) ? 'guru' : $rawRole;

        $rules = [
            'role_type' => ['required', Rule::in(['siswa', 'guru', 'staf', 'pegawai', 'alumni'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($roleType === 'siswa') {
            $rules['nisn'] = ['required', 'string', 'max:20'];
            $rules['kelas'] = ['required', 'string', 'max:50'];
        } elseif ($roleType === 'guru') {
            $rules['nip'] = ['nullable', 'string', 'max:30'];
            $rules['mata_pelajaran'] = ['required', 'string', 'max:100'];
        } elseif ($roleType === 'alumni') {
            $rules['tahun_lulus'] = ['required', 'numeric', 'min:1970', 'max:2035'];
            $rules['pekerjaan_kampus'] = ['required', 'string', 'max:150'];
        }

        $validated = $request->validate($rules, [], [
            'mata_pelajaran' => 'mata pelajaran / bidang tugas',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_type' => $roleType,
            'is_active' => false,
        ];

        if ($roleType === 'siswa') {
            $userData['nisn'] = $validated['nisn'];
            $userData['kelas'] = $validated['kelas'];
        } elseif ($roleType === 'guru') {
            $userData['nip'] = $validated['nip'] ?? null;
            $userData['mata_pelajaran'] = $validated['mata_pelajaran'];
        } elseif ($roleType === 'alumni') {
            $userData['tahun_lulus'] = (string) $validated['tahun_lulus'];
            $userData['pekerjaan_kampus'] = $validated['pekerjaan_kampus'];
        }

        $user = User::create($userData);

        $roleName = match ($roleType) {
            'guru' => 'Guru',
            'alumni' => 'Alumni',
            default => 'Siswa',
        };
        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
