<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Article;
use App\Models\ArticleReport;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $siswa;

    protected Category $category;

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
            'nisn' => '0098765432',
            'kelas' => 'XII MIPA 1',
        ]);
        $this->siswa->assignRole('Siswa');

        $this->category = Category::create([
            'name' => 'Opini Siswa',
            'slug' => 'opini-siswa',
            'type' => 'both',
        ]);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_dashboard_with_all_sections(): void
    {
        $pendingArticle = Article::create([
            'user_id' => $this->siswa->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Menunggu Moderasi Siswa',
            'slug' => 'artikel-menunggu-moderasi-siswa',
            'content' => 'Isi konten artikel suara warga yang menunggu moderasi dewan redaksi sekolah.',
            'status' => 'pending_review',
        ]);

        $jurnalArticle = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Berita Prestasi Resmi Siswa',
            'slug' => 'berita-prestasi-resmi-siswa',
            'content' => 'Isi berita resmi kegiatan sekolah SMAN 1 Malingping tercinta.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $comment = Comment::create([
            'article_id' => $jurnalArticle->id,
            'author_name' => 'Pengunjung Luar',
            'content' => 'Komentar antrean moderasi.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Sistem');
        $response->assertSee('Total Warga');
        $response->assertSee('Menunggu Tinjauan');
        $response->assertSee('Total Publikasi');
        $response->assertSee('Agenda Aktif');
        $response->assertSee('Antrean Moderasi (Suara Warga)');
        $response->assertDontSee('Registrasi Pengguna Baru');
        $response->assertDontSee('Manajemen Berita (Artikel & Berita)');
        $response->assertSee('Moderasi Komentar');
        $response->assertSee('Testimoni Alumni');
        $response->assertSee(route('admin.testimonials.index'));
        $response->assertSee('Artikel Menunggu Moderasi Siswa');
        $response->assertSee('Pengunjung Luar');
    }

    public function test_admin_can_approve_article_from_dashboard(): void
    {
        $article = Article::create([
            'user_id' => $this->siswa->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Cepat Setujui',
            'slug' => 'artikel-cepat-setujui',
            'content' => 'Konten suara warga yang akan langsung disetujui admin.',
            'status' => 'pending_review',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.moderate', $article->id), [
            'action' => 'approve',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $article->refresh();
        $this->assertEquals('published', $article->status);
    }

    public function test_admin_can_manage_categories(): void
    {
        $viewResponse = $this->actingAs($this->admin)->get(route('admin.categories.index'));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Kategori Konten');
        $viewResponse->assertSee('Opini Siswa');

        $createResponse = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Kategori Baru Pengumuman',
            'type' => 'jurnal',
            'color' => '#10B981',
            'description' => 'Deskripsi kategori baru',
        ]);
        $createResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Kategori Baru Pengumuman', 'type' => 'jurnal']);

        $category = Category::where('name', 'Kategori Baru Pengumuman')->first();

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category->id));
        $deleteResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_article_full_image_mode_renders_cinematic_breakout(): void
    {
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Berita Dengan Gambar Penuh',
            'slug' => 'berita-dengan-gambar-penuh',
            'content' => '<p>Paragraf isi berita yang memiliki ilustrasi cinematic breakout.</p>',
            'status' => 'published',
            'published_at' => now(),
            'featured_image' => 'articles/dummy.webp',
            'featured_image_mode' => 'full',
        ]);

        $response = $this->get(route('berita.show', $article->slug));
        $response->assertStatus(200);
        $response->assertSee('Berita Dengan Gambar Penuh');
        $response->assertSee('-mx-6 sm:-mx-10 md:-mx-24 lg:-mx-36');
    }

    public function test_admin_article_create_form_has_modern_droplists_and_responsive_styling(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.articles.create'));
        $response->assertStatus(200);
        $response->assertSee('Tulis Artikel / Berita');
        $response->assertSee('bg-transparent sm:bg-white');
        $response->assertSee('Tipe & Kategori', false);
        $response->assertSee('Kategori Tulisan');
        $response->assertSee('Status & Jadwal Publikasi', false);
        $response->assertDontSee('<select');
    }

    public function test_admin_can_create_article_with_publication_date(): void
    {
        $publishedDate = '2026-10-25T14:30';

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => 'Berita Terjadwal Masa Depan',
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'excerpt' => 'Ringkasan berita terjadwal',
            'content' => '<p>Konten lengkap berita dengan tanggal publikasi yang diatur manual.</p>',
            'status' => 'published',
            'published_at' => $publishedDate,
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Berita Terjadwal Masa Depan',
            'type' => 'jurnal',
            'status' => 'published',
        ]);

        $created = Article::where('title', 'Berita Terjadwal Masa Depan')->first();
        $this->assertNotNull($created->published_at);
        $this->assertEquals('2026-10-25 14:30:00', $created->published_at->format('Y-m-d H:i:s'));
        $this->assertEquals(route('berita.show', $created->slug), $created->url);
    }

    public function test_warga_article_create_form_has_modern_droplist(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('warga.articles.create'));
        $response->assertStatus(200);
        $response->assertSee('Tulis Karya Suara Warga');
        $response->assertSee('bg-transparent sm:bg-white');
        $response->assertSee('Pilih Kategori Tulisan...');
        $response->assertDontSee('<select');
    }

    public function test_admin_can_create_article_with_custom_slug(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => 'Judul Artikel Dengan Kustom Slug',
            'slug' => 'kustom-slug-saya',
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'excerpt' => 'Ringkasan artikel',
            'content' => '<p>Konten artikel lengkap dengan slug khusus.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Judul Artikel Dengan Kustom Slug',
            'slug' => 'kustom-slug-saya',
        ]);
    }

    public function test_admin_can_update_article_slug(): void
    {
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Lama',
            'slug' => 'artikel-lama-awal',
            'excerpt' => 'Ringkasan',
            'content' => '<p>Konten lama.</p>',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article), [
            'title' => 'Artikel Diperbarui',
            'slug' => 'artikel-slug-terbaru',
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'content' => '<p>Konten baru diperbarui.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Artikel Diperbarui',
            'slug' => 'artikel-slug-terbaru',
        ]);
    }

    public function test_admin_can_update_category(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $this->category), [
            'name' => 'Opini & Karya Siswa Terupdate',
            'slug' => 'opini-karya-siswa-update',
            'type' => 'suara_warga',
            'color' => '#10B981',
            'description' => 'Deskripsi kategori baru',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'name' => 'Opini & Karya Siswa Terupdate',
            'slug' => 'opini-karya-siswa-update',
            'type' => 'suara_warga',
            'color' => '#10B981',
        ]);
    }

    public function test_admin_can_update_user_details_and_role(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $this->siswa), [
            'name' => 'Ahmad Siswa Hebat',
            'email' => 'ahmad.siswa@sman1malingping.sch.id',
            'role_type' => 'alumni',
            'tahun_lulus' => '2025',
            'pekerjaan_kampus' => 'Universitas Indonesia',
            'is_active' => '1',
            'is_verified' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->siswa->id,
            'name' => 'Ahmad Siswa Hebat',
            'email' => 'ahmad.siswa@sman1malingping.sch.id',
            'role_type' => 'alumni',
            'tahun_lulus' => '2025',
            'is_active' => true,
        ]);
        $this->assertNotNull($this->siswa->fresh()->email_verified_at);
    }

    public function test_admin_can_toggle_user_email_verification(): void
    {
        $this->siswa->update(['email_verified_at' => null]);

        $response = $this->actingAs($this->admin)->patch(route('admin.users.verify-email', $this->siswa));
        $response->assertRedirect();
        $this->assertNotNull($this->siswa->fresh()->email_verified_at);

        // Toggle back to unverified
        $response = $this->actingAs($this->admin)->patch(route('admin.users.verify-email', $this->siswa));
        $response->assertRedirect();
        $this->assertNull($this->siswa->fresh()->email_verified_at);
    }

    public function test_admin_can_delete_warga_user(): void
    {
        $userToDelete = User::factory()->create([
            'role_type' => 'siswa',
            'name' => 'Siswa Dihapus',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $userToDelete));
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_super_admin_does_not_appear_in_user_index_for_school_admin(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin = User::factory()->create([
            'role_type' => 'super_admin',
            'name' => 'Master Super Admin',
            'email' => 'superadmin.secret@sman1malingping.sch.id',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200);

        $users = $response->viewData('users');
        $this->assertFalse($users->pluck('id')->contains($superAdmin->id));
        $response->assertDontSee('Master Super Admin');
        $response->assertDontSee('superadmin.secret@sman1malingping.sch.id');
    }

    public function test_super_admin_appears_in_user_index_when_logged_in_as_super_admin(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin = User::factory()->create([
            'role_type' => 'super_admin',
            'name' => 'Master Super Admin',
            'email' => 'superadmin.visible@sman1malingping.sch.id',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        $response = $this->actingAs($superAdmin)->get(route('admin.users.index'));
        $response->assertStatus(200);

        $users = $response->viewData('users');
        $this->assertTrue($users->pluck('id')->contains($superAdmin->id));
        $response->assertSee('Master Super Admin');
    }

    public function test_school_admin_cannot_modify_super_admin(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin = User::factory()->create([
            'role_type' => 'super_admin',
            'name' => 'Protected Super Admin',
            'email' => 'superadmin.protected@sman1malingping.sch.id',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        // Update attempt
        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $superAdmin), [
            'name' => 'Hacked Admin',
            'email' => 'hacked@sman1malingping.sch.id',
            'role_type' => 'admin',
        ]);
        $response->assertSessionHas('error');
        $this->assertEquals('Protected Super Admin', $superAdmin->fresh()->name);

        // Activation toggle attempt
        $responseActivation = $this->actingAs($this->admin)->patch(route('admin.users.activation', $superAdmin));
        $responseActivation->assertSessionHas('error');
        $this->assertTrue($superAdmin->fresh()->is_active);

        // Email verification toggle attempt
        $responseVerify = $this->actingAs($this->admin)->patch(route('admin.users.verify-email', $superAdmin));
        $responseVerify->assertSessionHas('error');
    }

    public function test_admin_dashboard_moderation_comments_only_displays_pending_comments(): void
    {
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Berita Terbuka',
            'slug' => 'artikel-berita-terbuka',
            'content' => 'Konten artikel berita untuk uji komentar.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $pendingComment = Comment::create([
            'article_id' => $article->id,
            'author_name' => 'Warga Pending',
            'content' => 'Komentar ini menunggu persetujuan admin.',
            'status' => 'pending',
        ]);

        $approvedComment = Comment::create([
            'article_id' => $article->id,
            'author_name' => 'Warga Sudah Disetujui',
            'content' => 'Komentar ini sudah disetujui sebelumnya.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Warga Pending');
        $response->assertSee('Komentar ini menunggu persetujuan admin.');
        $response->assertDontSee('Warga Sudah Disetujui');
        $response->assertDontSee('Komentar ini sudah disetujui sebelumnya.');

        $moderationComments = $response->viewData('moderationComments');
        $this->assertTrue($moderationComments->contains('id', $pendingComment->id));
        $this->assertFalse($moderationComments->contains('id', $approvedComment->id));
    }

    public function test_admin_articles_index_renders_action_buttons_with_icons(): void
    {
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Uji Menu Aksi',
            'slug' => 'artikel-uji-menu-aksi',
            'content' => 'Konten untuk menguji menu aksi dengan ikon.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.articles.index'));

        $response->assertStatus(200);
        $response->assertSee('title="Lihat Artikel"', false);
        $response->assertSee('title="Edit Artikel"', false);
        $response->assertSee('title="Hapus Artikel"', false);
        $response->assertSee(route('admin.articles.edit', $article->id));
    }

    public function test_admin_articles_comments_and_users_are_paginated_by_10(): void
    {
        // 1. Articles pagination
        for ($i = 1; $i <= 12; $i++) {
            Article::create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
                'type' => 'jurnal',
                'title' => "Artikel Pagination {$i}",
                'slug' => "artikel-pagination-{$i}",
                'content' => "Isi artikel ke-{$i}",
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        $responseArticles = $this->actingAs($this->admin)->get(route('admin.articles.index'));
        $responseArticles->assertStatus(200);
        $articles = $responseArticles->viewData('articles');
        $this->assertEquals(10, $articles->perPage());
        $this->assertGreaterThanOrEqual(12, $articles->total());
        $this->assertCount(10, $articles->items());

        // 2. Comments pagination
        $firstArticle = Article::first();
        for ($i = 1; $i <= 12; $i++) {
            Comment::create([
                'article_id' => $firstArticle->id,
                'author_name' => "Pengomentar {$i}",
                'content' => "Isi komentar ke-{$i}",
                'status' => 'approved',
            ]);
        }

        $responseComments = $this->actingAs($this->admin)->get(route('admin.comments.index'));
        $responseComments->assertStatus(200);
        $comments = $responseComments->viewData('comments');
        $this->assertEquals(10, $comments->perPage());
        $this->assertGreaterThanOrEqual(12, $comments->total());
        $this->assertCount(10, $comments->items());

        // 3. Users pagination
        User::factory()->count(12)->create([
            'role_type' => 'siswa',
            'is_active' => true,
        ]);

        $responseUsers = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $responseUsers->assertStatus(200);
        $users = $responseUsers->viewData('users');
        $this->assertEquals(10, $users->perPage());
        $this->assertGreaterThanOrEqual(12, $users->total());
        $this->assertCount(10, $users->items());
    }

    public function test_admin_index_pages_use_icon_actions_without_raw_text_labels(): void
    {
        // 1. Categories
        $responseCategories = $this->actingAs($this->admin)->get(route('admin.categories.index'));
        $responseCategories->assertStatus(200);
        $responseCategories->assertSee('title="Edit Kategori"', false);
        $responseCategories->assertSee('title="Hapus Kategori"', false);

        // 2. Comments
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Indeks Ikon',
            'slug' => 'artikel-indeks-ikon',
            'content' => 'Konten artikel untuk relasi komentar dan laporan',
            'status' => 'published',
            'published_at' => now(),
        ]);
        Comment::create([
            'article_id' => $article->id,
            'author_name' => 'Komentator Uji Aksi Ikon',
            'content' => 'Komentar untuk cek tombol aksi ikon',
            'status' => 'pending',
        ]);
        $responseComments = $this->actingAs($this->admin)->get(route('admin.comments.index'));
        $responseComments->assertStatus(200);
        $responseComments->assertSee('title="Setujui Komentar"', false);
        $responseComments->assertSee('title="Tandai Spam"', false);
        $responseComments->assertSee('title="Hapus Komentar"', false);

        // 3. Agendas
        Agenda::create([
            'title' => 'Agenda Uji Aksi Ikon',
            'description' => 'Deskripsi kegiatan agenda sekolah',
            'event_date' => now()->addDays(5),
            'location' => 'Aula Sekolah',
            'is_active' => true,
        ]);
        $responseAgendas = $this->actingAs($this->admin)->get(route('admin.agendas.index'));
        $responseAgendas->assertStatus(200);
        $responseAgendas->assertSee('title="Edit Agenda"', false);
        $responseAgendas->assertSee('title="Hapus Agenda"', false);

        // 4. Reports
        ArticleReport::create([
            'article_id' => $article->id,
            'user_id' => $this->siswa->id,
            'reason' => 'spam',
            'details' => 'Laporan uji coba ikon',
            'status' => 'pending',
        ]);
        $responseReports = $this->actingAs($this->admin)->get(route('admin.reports.index'));
        $responseReports->assertStatus(200);
        $responseReports->assertSee('title="Tinjau & Tindaklanjuti Laporan"', false);
        $responseReports->assertSee('title="Hapus Laporan"', false);
    }

    public function test_admin_articles_are_ordered_by_published_at_date(): void
    {
        $articleOld = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Lama',
            'slug' => 'artikel-lama',
            'content' => 'Konten lama',
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'created_at' => now()->subDays(1), // created more recently, but published earlier
        ]);

        $articleNew = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Baru Terbit',
            'slug' => 'artikel-baru-terbit',
            'content' => 'Konten baru terbit',
            'status' => 'published',
            'published_at' => now()->subMinutes(10),
            'created_at' => now()->subDays(10), // created earlier, but published more recently
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.articles.index'));
        $response->assertStatus(200);

        $items = $response->viewData('articles')->items();
        $ids = array_map(fn ($item) => $item->id, $items);

        $posNew = array_search($articleNew->id, $ids);
        $posOld = array_search($articleOld->id, $ids);

        $this->assertNotFalse($posNew);
        $this->assertNotFalse($posOld);
        $this->assertLessThan($posOld, $posNew, 'Artikel dengan published_at lebih baru harus berada di urutan atas.');
    }
}
