<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WargaDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Siswa']);
        Role::firstOrCreate(['name' => 'Guru']);
        Role::firstOrCreate(['name' => 'Alumni']);
    }

    public function test_guests_cannot_access_warga_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_warga_can_view_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'role_type' => 'alumni',
            'is_active' => true,
        ]);
        $user->assignRole('Alumni');

        $category = Category::create([
            'name' => 'Opini Alumni',
            'slug' => 'opini-alumni',
            'type' => 'suara_warga',
        ]);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'suara_warga',
            'title' => 'Perjalanan Merantau Setelah Lulus',
            'slug' => 'perjalanan-merantau-setelah-lulus',
            'content' => 'Ini adalah konten artikel alumni yang sangat bermanfaat.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dasbor Warga - SMAN 1 Malingping');
        $response->assertSee($user->name);
        $response->assertSee('Panduan Menulis');
        $response->assertSee('Pedoman Komunitas');
        $response->assertSee('Total Karya');
        $response->assertSee('Total Apresiasi');
    }
}
