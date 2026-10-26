<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloatingAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_floating_announcement_renders_when_active(): void
    {
        Announcement::create([
            'title' => 'Survei Kepuasan Masyarakat',
            'type' => 'floating',
            'content' => 'Silakan isi kuesioner survei kepuasan pelayanan sekolah.',
            'button_text' => 'Isi Survei',
            'button_url' => 'https://forms.gle/sample-skm',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Check floating button on the left
        $response->assertSee('Survei Kepuasan Masyarakat');
        $response->assertSee('Pengumuman Mengambang', false);
        $response->assertSee('bottom-4 left-4');

        // Check modal popup elements
        $response->assertSee('Silakan isi kuesioner survei kepuasan pelayanan sekolah.');
        $response->assertSee('Isi Survei');
        $response->assertSee('https://forms.gle/sample-skm');
        $response->assertSee('target="_blank"', false);
    }

    public function test_popup_announcement_renders_popup_model(): void
    {
        Announcement::create([
            'title' => 'Pemberitahuan Ujian Sekolah',
            'type' => 'popup',
            'content' => 'Ujian dimulai hari Senin depan.',
            'button_text' => 'Lihat Jadwal',
            'button_url' => 'https://sman1malingping.sch.id/jadwal',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Should render popup modal
        $response->assertSee('Pemberitahuan Ujian Sekolah');
        $response->assertSee('Pengumuman Resmi');
        $response->assertSee('Ujian dimulai hari Senin depan.');

        // Should NOT render floating button on the left for pure popup type
        $response->assertDontSee('Pengumuman Mengambang');
    }

    public function test_floating_announcement_does_not_render_when_inactive(): void
    {
        Announcement::create([
            'title' => 'Survei Kepuasan Masyarakat Nonaktif',
            'type' => 'floating',
            'content' => 'Konten pengumuman nonaktif.',
            'button_text' => 'Isi Survei',
            'button_url' => 'https://forms.gle/sample-skm',
            'is_active' => false,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertDontSee('Survei Kepuasan Masyarakat Nonaktif');
        $response->assertDontSee('Pengumuman Mengambang');
    }

    public function test_header_border_is_white(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('border-white');
    }

    public function test_admin_can_manage_and_toggle_announcement_type(): void
    {
        $admin = User::factory()->create([
            'role_type' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/announcements', [
            'title' => 'Survei Fasilitas Sekolah',
            'type' => 'floating',
            'content' => 'Kuesioner fasilitas.',
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/announcements');
        $this->assertDatabaseHas('announcements', [
            'title' => 'Survei Fasilitas Sekolah',
            'type' => 'floating',
        ]);

        $announcement = Announcement::where('title', 'Survei Fasilitas Sekolah')->first();

        // Toggle status
        $toggleResponse = $this->actingAs($admin)
            ->patch(route('admin.announcements.toggle-status', $announcement));

        $toggleResponse->assertRedirect();
        $this->assertFalse($announcement->fresh()->is_active);
    }
}
