<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Siswa']);
        Role::firstOrCreate(['name' => 'Guru']);
        Role::firstOrCreate(['name' => 'Alumni']);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'role_type' => 'siswa',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'nisn' => '0091234567',
            'kelas' => 'XII MIPA 1',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice', absolute: false));
    }

    public function test_teacher_can_register(): void
    {
        $response = $this->post('/register', [
            'role_type' => 'guru',
            'name' => 'Pak Guru Matematika',
            'email' => 'guru@example.com',
            'nip' => '198501012010011001',
            'mata_pelajaran' => 'Matematika',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice', absolute: false));

        $user = \App\Models\User::where('email', 'guru@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('guru', $user->role_type);
        $this->assertEquals('Guru / Staf', $user->role_badge['label']);
        $this->assertEquals('Guru Matematika', $user->role_detail);
    }

    public function test_staff_can_register_with_staf_or_pegawai_role(): void
    {
        $response = $this->post('/register', [
            'role_type' => 'staf',
            'name' => 'Ibu Staf Tata Usaha',
            'email' => 'staf@example.com',
            'nip' => '199002022015022002',
            'mata_pelajaran' => 'Staf Tata Usaha & Kepegawaian',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice', absolute: false));

        $user = \App\Models\User::where('email', 'staf@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('guru', $user->role_type);
        $this->assertEquals('Guru / Staf', $user->role_badge['label']);
        $this->assertEquals('Staf Tata Usaha & Kepegawaian', $user->role_detail);
    }
}
