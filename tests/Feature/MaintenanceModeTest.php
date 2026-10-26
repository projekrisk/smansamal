<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Siswa']);

        $this->admin = User::factory()->create([
            'role_type' => 'admin',
            'is_active' => true,
        ]);
        $this->admin->assignRole('Admin');

        $this->siswa = User::factory()->create([
            'role_type' => 'siswa',
            'is_active' => true,
        ]);
        $this->siswa->assignRole('Siswa');

        config(['app.maintenance.enabled' => false]);
    }

    public function test_public_users_can_access_site_when_maintenance_is_disabled(): void
    {
        Setting::set('maintenance_enabled', '0');

        $response = $this->get('/');
        $response->assertStatus(200);

        // Visiting /pemeliharaan directly when maintenance is off redirects to home
        $maintenanceResponse = $this->get('/pemeliharaan');
        $maintenanceResponse->assertRedirect(route('home'));
    }

    public function test_public_users_are_redirected_to_pemeliharaan_when_enabled_via_setting(): void
    {
        Setting::set('maintenance_enabled', '1');
        Setting::set('maintenance_title', 'Perbaikan Server Sekolah');
        Setting::set('maintenance_message', 'Situs sedang dioptimalkan untuk PPDB.');
        Setting::set('maintenance_end_time', '27 Oktober 2026, 12:00 WIB');

        // Accessing any public page redirects to /pemeliharaan
        $response = $this->get('/');
        $response->assertRedirect('/pemeliharaan');

        // Accessing /pemeliharaan returns 503 with maintenance content
        $pageResponse = $this->get('/pemeliharaan');
        $pageResponse->assertStatus(503);
        $pageResponse->assertSee('Perbaikan Server Sekolah');
        $pageResponse->assertSee('Situs sedang dioptimalkan untuk PPDB.');
        $pageResponse->assertSee('27 Oktober 2026, 12:00 WIB');
    }

    public function test_public_users_are_redirected_to_pemeliharaan_when_enabled_via_config(): void
    {
        Setting::set('maintenance_enabled', '0');
        config([
            'app.maintenance.enabled' => true,
            'app.maintenance.title' => 'Pemeliharaan Via Konfigurasi ENV',
        ]);

        $response = $this->get('/');
        $response->assertRedirect('/pemeliharaan');

        $pageResponse = $this->get('/pemeliharaan');
        $pageResponse->assertStatus(503);
        $pageResponse->assertSee('Pemeliharaan Via Konfigurasi ENV');
    }

    public function test_pemeliharan_typo_route_redirects_to_pemeliharaan(): void
    {
        Setting::set('maintenance_enabled', '1');

        $response = $this->get('/pemeliharan');
        $response->assertRedirect('/pemeliharaan');
    }

    public function test_exempt_paths_are_accessible_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');

        $this->get('/login')->assertStatus(200);
        $this->get('/admin/login')->assertStatus(200);
        $this->get('/up')->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_site_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');

        $response = $this->actingAs($this->admin)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Mode Pemeliharaan Aktif');
    }

    public function test_secret_bypass_key_allows_access(): void
    {
        Setting::set('maintenance_enabled', '1');
        Setting::set('maintenance_secret', 'kunci-rahasia-123');

        $response = $this->get('/');
        $response->assertRedirect('/pemeliharaan');

        $responseWithBypass = $this->get('/?bypass=kunci-rahasia-123');
        $responseWithBypass->assertStatus(200);
        $responseWithBypass->assertCookie('maintenance_bypass', 'kunci-rahasia-123');

        $responseWithCookie = $this->withCookie('maintenance_bypass', 'kunci-rahasia-123')->get('/');
        $responseWithCookie->assertStatus(200);
    }

    public function test_api_requests_receive_json_response_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');
        Setting::set('maintenance_title', 'API Sedang Maintenance');

        $response = $this->getJson('/api/pengumuman-aktif');
        $response->assertStatus(503);
        $response->assertJson([
            'message' => 'API Sedang Maintenance',
            'status' => 503,
        ]);
    }

    public function test_non_admin_cannot_access_maintenance_settings(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('admin.maintenance.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_and_update_maintenance_settings(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.maintenance.index'));
        $response->assertStatus(200);
        $response->assertSee('Mode Pemeliharaan (Maintenance)');

        $updateResponse = $this->actingAs($this->admin)->post(route('admin.maintenance.update'), [
            'maintenance_enabled' => '1',
            'maintenance_title' => 'Pemeliharaan Rutin Weekend',
            'maintenance_message' => 'Sedang dilakukan backup basis data.',
            'maintenance_end_time' => 'Minggu, 18:00 WIB',
            'maintenance_secret' => 'bypass-token-test',
        ]);

        $updateResponse->assertRedirect(route('admin.maintenance.index'));
        $updateResponse->assertSessionHas('success');

        $this->assertTrue(Setting::getBool('maintenance_enabled'));
        $this->assertEquals('Pemeliharaan Rutin Weekend', Setting::get('maintenance_title'));
        $this->assertEquals('Sedang dilakukan backup basis data.', Setting::get('maintenance_message'));
        $this->assertEquals('Minggu, 18:00 WIB', Setting::get('maintenance_end_time'));
        $this->assertEquals('bypass-token-test', Setting::get('maintenance_secret'));
    }

    public function test_admin_can_preview_maintenance_page(): void
    {
        Setting::set('maintenance_enabled', '0');
        Setting::set('maintenance_title', 'Pratinjau Pemeliharaan');

        $response = $this->actingAs($this->admin)->get(route('admin.maintenance.preview'));
        $response->assertStatus(200);
        $response->assertSee('Pratinjau Pemeliharaan');
    }
}
