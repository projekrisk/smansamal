<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage_users',
            'manage_articles',
            'publish_articles',
            'moderate_articles',
            'manage_agendas',
            'moderate_comments',
            'write_suara_warga',
            'write_comments',
            'submit_testimonial',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $guruRole = Role::firstOrCreate(['name' => 'Guru']);
        $siswaRole = Role::firstOrCreate(['name' => 'Siswa']);
        $alumniRole = Role::firstOrCreate(['name' => 'Alumni']);

        $superAdminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions([
            'manage_articles',
            'publish_articles',
            'moderate_articles',
            'manage_agendas',
            'moderate_comments',
            'write_suara_warga',
            'write_comments',
        ]);
        $guruRole->syncPermissions(['write_suara_warga', 'write_comments']);
        $siswaRole->syncPermissions(['write_suara_warga', 'write_comments']);
        $alumniRole->syncPermissions(['write_suara_warga', 'write_comments', 'submit_testimonial']);

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@sman1malingping.sch.id'],
            [
                'name' => 'Kepala Sekolah SMAN 1 Malingping',
                'password' => Hash::make('password'),
                'role_type' => 'super_admin',
                'bio' => 'Kepala SMAN 1 Malingping. Berkomitmen mewujudkan sekolah berwawasan lingkungan dan generasi cerdas berkarakter.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300&auto=format&fit=crop',
                'is_active' => true,
                'activated_at' => now(),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $admin = User::firstOrCreate(
            ['email' => 'admin@sman1malingping.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd.',
                'password' => Hash::make('password'),
                'role_type' => 'admin',
                'nip' => '198204152009021003',
                'mata_pelajaran' => 'Biologi & Humas Sekolah',
                'bio' => 'Mengabdi sejak tahun 2015, berfokus pada pendidikan lingkungan dan ekologi kelautan. Aktif membimbing siswa dalam karya ilmiah remaja dan kegiatan olimpiade sains tingkat provinsi maupun nasional.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80',
                'is_active' => true,
                'activated_at' => now(),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        $this->call(PageSeeder::class);
    }
}
