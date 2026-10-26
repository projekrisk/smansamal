<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $status = $request->query('status');
        $search = $request->query('q');

        $query = User::withCount('articles')->with('roles');

        if (! auth()->user()->isSuperAdmin()) {
            $query->where('role_type', '!=', 'super_admin')
                ->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'Super Admin');
                });
        }

        if ($role) {
            $query->where('role_type', $role);
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'pending') {
            $query->where('is_active', false);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'status', 'search'));
    }

    public function update(Request $request, User $user)
    {
        if (! auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang dapat mengubah data akun Super Admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role_type' => 'required|in:siswa,guru,alumni,admin,super_admin',
            'nisn' => 'nullable|string|max:30',
            'kelas' => 'nullable|string|max:50',
            'nip' => 'nullable|string|max:30',
            'mata_pelajaran' => 'nullable|string|max:100',
            'tahun_lulus' => 'nullable|string|max:10',
            'pekerjaan_kampus' => 'nullable|string|max:150',
            'bio' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6',
            'is_active' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
        ]);

        if (! auth()->user()->isSuperAdmin()) {
            if ($validated['role_type'] === 'super_admin') {
                return back()->with('error', 'Hanya Super Admin yang dapat memberi hak Super Admin.');
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_type = $validated['role_type'];
        $user->nisn = $validated['nisn'] ?? null;
        $user->kelas = $validated['kelas'] ?? null;
        $user->nip = $validated['nip'] ?? null;
        $user->mata_pelajaran = $validated['mata_pelajaran'] ?? null;
        $user->tahun_lulus = $validated['tahun_lulus'] ?? null;
        $user->pekerjaan_kampus = $validated['pekerjaan_kampus'] ?? null;
        $user->bio = $validated['bio'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $isActive = $request->boolean('is_active');
        $user->is_active = $isActive;
        if ($isActive && ! $user->activated_at) {
            $user->activated_at = now();
        }

        $isVerified = $request->boolean('is_verified');
        if ($isVerified && ! $user->email_verified_at) {
            $user->email_verified_at = now();
        } elseif (! $isVerified && $user->email_verified_at) {
            $user->email_verified_at = null;
        }

        $user->save();

        $roleName = match ($validated['role_type']) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'guru' => 'Guru',
            'alumni' => 'Alumni',
            default => 'Siswa',
        };

        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->syncRoles([$role]);

        return back()->with('success', "Data warga \"{$user->name}\" berhasil diperbarui.");
    }

    public function toggleActivation(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        if (! auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang berhak mengubah status aktivasi akun Super Admin.');
        }

        $user->is_active = ! $user->is_active;
        if ($user->is_active && ! $user->activated_at) {
            $user->activated_at = now();
        }
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$statusStr}.");
    }

    public function toggleEmailVerification(User $user)
    {
        if (! auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang berhak mengubah verifikasi email akun Super Admin.');
        }

        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $msg = "Verifikasi email akun {$user->name} dibatalkan.";
        } else {
            $user->email_verified_at = now();
            $msg = "Email akun {$user->name} berhasil diverifikasi.";
        }
        $user->save();

        return back()->with('success', $msg);
    }

    public function updateRole(Request $request, User $user)
    {
        if (! auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang dapat mengubah peran Super Admin.');
        }

        $validated = $request->validate([
            'role_type' => 'required|in:siswa,guru,alumni,admin,super_admin',
        ]);

        if (! auth()->user()->isSuperAdmin()) {
            if ($validated['role_type'] === 'super_admin') {
                return back()->with('error', 'Hanya Super Admin yang dapat memberi hak Super Admin.');
            }
        }

        $user->role_type = $validated['role_type'];
        $user->save();

        $roleName = match ($validated['role_type']) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'guru' => 'Guru',
            'alumni' => 'Alumni',
            default => 'Siswa',
        };

        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->syncRoles([$role]);

        return back()->with('success', "Peran pengguna {$user->name} diperbarui menjadi {$roleName}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if (! auth()->user()->isSuperAdmin() && ($user->isAdmin() || $user->isSuperAdmin())) {
            return back()->with('error', 'Hanya Super Admin yang berhak menghapus akun administrator.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Akun warga \"{$name}\" berhasil dihapus.");
    }
}
