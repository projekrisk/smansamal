<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $warga;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Siswa']);

        $this->admin = User::factory()->create([
            'name' => 'Admin Pengelola',
            'email' => 'admin@test.sch.id',
            'role_type' => 'admin',
            'is_active' => true,
        ]);
        $this->admin->assignRole('Admin');

        $this->warga = User::factory()->create([
            'name' => 'Siswa Penguji',
            'email' => 'siswa@test.sch.id',
            'role_type' => 'siswa',
            'is_active' => true,
        ]);
        $this->warga->assignRole('Siswa');
    }

    public function test_guest_and_non_admin_cannot_access_page_management(): void
    {
        $guestResponse = $this->get(route('admin.pages.index'));
        $guestResponse->assertRedirect();

        $wargaResponse = $this->actingAs($this->warga)->get(route('admin.pages.index'));
        $wargaResponse->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_pages_index(): void
    {
        Page::create([
            'title' => 'Profil Sekolah',
            'slug' => 'profil-sekolah',
            'content' => '<p>Konten visi dan misi sekolah.</p>',
            'is_active' => true,
            'is_system' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.pages.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Halaman');
        $response->assertSee('Profil Sekolah');
        $response->assertSee('Sistem Bawaan');
    }

    public function test_admin_can_filter_and_search_pages(): void
    {
        Page::create([
            'title' => 'Tata Tertib Perpustakaan',
            'slug' => 'tata-tertib-perpustakaan',
            'content' => '<p>Peraturan peminjaman buku.</p>',
            'is_active' => true,
            'is_system' => false,
        ]);

        Page::create([
            'title' => 'Panduan Laboratorium',
            'slug' => 'panduan-laboratorium',
            'content' => '<p>Aturan keselamatan kerja laboratorium.</p>',
            'is_active' => false,
            'is_system' => false,
        ]);

        $searchResponse = $this->actingAs($this->admin)->get(route('admin.pages.index', ['q' => 'Perpustakaan']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Tata Tertib Perpustakaan');
        $searchResponse->assertDontSee('Panduan Laboratorium');

        $draftResponse = $this->actingAs($this->admin)->get(route('admin.pages.index', ['status' => 'draft']));
        $draftResponse->assertStatus(200);
        $draftResponse->assertSee('Panduan Laboratorium');
        $draftResponse->assertDontSee('Tata Tertib Perpustakaan');
    }

    public function test_admin_can_create_new_static_page(): void
    {
        $createPageResponse = $this->actingAs($this->admin)->get(route('admin.pages.create'));
        $createPageResponse->assertStatus(200);
        $createPageResponse->assertSee('Buat Halaman Statis Baru');

        $storeResponse = $this->actingAs($this->admin)->post(route('admin.pages.store'), [
            'title' => 'Ekstrakurikuler Unggulan',
            'slug' => 'ekstrakurikuler-unggulan',
            'content' => '<h2>Daftar Ekskul</h2><p>Pramuka, Paskibra, PMR, dan Robotik.</p>',
            'meta_description' => 'Daftar kegiatan ekstrakurikuler di SMAN 1 Malingping.',
            'is_active' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.pages.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('pages', [
            'title' => 'Ekstrakurikuler Unggulan',
            'slug' => 'ekstrakurikuler-unggulan',
            'is_active' => true,
            'is_system' => false,
        ]);
    }

    public function test_admin_can_edit_and_update_static_page(): void
    {
        $page = Page::create([
            'title' => 'Halaman Awal',
            'slug' => 'halaman-awal',
            'content' => '<p>Konten lama.</p>',
            'is_active' => true,
            'is_system' => false,
        ]);

        $editResponse = $this->actingAs($this->admin)->get(route('admin.pages.edit', $page->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Halaman Awal');

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.pages.update', $page->id), [
            'title' => 'Halaman Diperbarui',
            'slug' => 'halaman-diperbarui',
            'content' => '<p>Konten yang telah direvisi.</p>',
            'meta_description' => 'Deskripsi baru.',
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect(route('admin.pages.index'));
        $updateResponse->assertSessionHas('success');

        $page->refresh();
        $this->assertEquals('Halaman Diperbarui', $page->title);
        $this->assertEquals('halaman-diperbarui', $page->slug);
    }

    public function test_admin_can_toggle_page_status(): void
    {
        $page = Page::create([
            'title' => 'Halaman Status',
            'slug' => 'halaman-status',
            'content' => '<p>Konten status.</p>',
            'is_active' => true,
        ]);

        $toggleResponse = $this->actingAs($this->admin)->patch(route('admin.pages.toggle-status', $page->id));
        $toggleResponse->assertRedirect();

        $page->refresh();
        $this->assertFalse($page->is_active);

        $this->actingAs($this->admin)->patch(route('admin.pages.toggle-status', $page->id));
        $page->refresh();
        $this->assertTrue($page->is_active);
    }

    public function test_admin_can_delete_custom_page(): void
    {
        $page = Page::create([
            'title' => 'Halaman Dihapus',
            'slug' => 'halaman-dihapus',
            'content' => '<p>Akan segera dihapus.</p>',
            'is_system' => false,
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.pages.destroy', $page->id));
        $deleteResponse->assertRedirect(route('admin.pages.index'));
        $deleteResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_admin_cannot_delete_system_page(): void
    {
        $systemPage = Page::create([
            'title' => 'Syarat & Ketentuan',
            'slug' => 'syarat-ketentuan',
            'content' => '<p>Ketentuan sistem.</p>',
            'is_system' => true,
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.pages.destroy', $systemPage->id));
        $deleteResponse->assertRedirect();
        $deleteResponse->assertSessionHas('error');

        $this->assertDatabaseHas('pages', ['id' => $systemPage->id]);
    }

    public function test_public_can_view_active_static_page(): void
    {
        $page = Page::create([
            'title' => 'Struktur Organisasi',
            'slug' => 'struktur-organisasi',
            'content' => '<h2>Bagan Kepengurusan</h2><p>Daftar pimpinan dan dewan guru.</p>',
            'is_active' => true,
        ]);

        $this->assertStringNotContainsString('/halaman/', route('pages.show', 'struktur-organisasi'));
        $this->assertEquals(url('/struktur-organisasi'), route('pages.show', 'struktur-organisasi'));

        $response = $this->get(route('pages.show', 'struktur-organisasi'));
        $response->assertStatus(200);
        $response->assertSee('Struktur Organisasi');
        $response->assertSee('Bagan Kepengurusan');
        $response->assertDontSee('bg-white p-6 sm:p-10 md:p-12');

        $page->refresh();
        $this->assertEquals(1, $page->views_count);

        $systemPage = Page::create([
            'title' => 'Ketentuan Sistem Khusus',
            'slug' => 'ketentuan-sistem-khusus',
            'content' => '<p>Konten sistem dengan latar putih.</p>',
            'is_active' => true,
            'is_system' => true,
        ]);

        $systemResponse = $this->get(route('pages.show', 'ketentuan-sistem-khusus'));
        $systemResponse->assertStatus(200);
        $systemResponse->assertSee('bg-white p-6 sm:p-10 md:p-12');
    }

    public function test_public_cannot_view_inactive_draft_static_page(): void
    {
        Page::create([
            'title' => 'Halaman Rahasia Draf',
            'slug' => 'halaman-rahasia-draf',
            'content' => '<p>Masih dalam tahap penyusunan.</p>',
            'is_active' => false,
        ]);

        $response = $this->get(route('pages.show', 'halaman-rahasia-draf'));
        $response->assertStatus(404);
    }

    public function test_public_can_view_kontak_system_page(): void
    {
        $kontakPage = Page::create([
            'title' => 'Kontak',
            'slug' => 'kontak',
            'content' => '<p>Layanan informasi resmi sekolah.</p>',
            'meta_description' => 'Informasi kontak resmi SMA Negeri 1 Malingping.',
            'is_active' => true,
            'is_system' => true,
        ]);

        $this->assertEquals(route('contact'), $kontakPage->public_url);
        $this->assertEquals(url('/kontak'), route('contact'));

        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Kontak');
        $response->assertSee('Alamat Kampus');
        $response->assertSee('Surel Resmi');
        $response->assertSee('Jam Pelayanan');
        $response->assertSee('Panduan Kunjungan Tamu');
        $response->assertSee('Informasi Terkait');
        $response->assertDontSee('Telepon Kantor');
        $response->assertDontSee('Kirim Pertanyaan / Aspirasi');
        $response->assertDontSee('Peta Lokasi & Navigasi Kampus');
        $response->assertDontSee('Hubungi SMAN 1 Malingping');

        $kontakPage->refresh();
        $this->assertEquals(1, $kontakPage->views_count);
    }
}
