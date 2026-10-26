<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleReport;
use App\Models\Category;
use App\Models\User;
use App\Notifications\ArticleReportedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ArticleReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $user;

    protected Article $article;

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

        $this->user = User::factory()->create([
            'role_type' => 'siswa',
            'is_active' => true,
        ]);
        $this->user->assignRole('Siswa');

        $this->category = Category::create([
            'name' => 'Opini Warga',
            'slug' => 'opini-warga',
            'type' => 'suara_warga',
        ]);

        $this->article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => 'Judul Artikel Kontroversial',
            'slug' => 'judul-artikel-kontroversial',
            'content' => 'Konten artikel lengkap yang menarik untuk dibaca.',
            'status' => 'published',
            'type' => 'suara_warga',
            'published_at' => now(),
        ]);
    }

    public function test_authenticated_user_can_report_an_article_and_admins_receive_notification(): void
    {
        Notification::fake();

        $response = $this->actingAs($this->user)->postJson(route('articles.report', $this->article->id), [
            'reason' => 'inappropriate',
            'details' => 'Terdapat bagian teks yang tidak sopan di paragraf kedua.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('article_reports', [
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'inappropriate',
            'status' => 'pending',
        ]);

        Notification::assertSentTo($this->admin, ArticleReportedNotification::class);
    }

    public function test_guest_can_report_an_article_with_optional_contact_info(): void
    {
        Notification::fake();

        $response = $this->post(route('articles.report', $this->article->id), [
            'reason' => 'spam',
            'reporter_name' => 'Budi Tamu',
            'reporter_email' => 'budi@example.com',
            'details' => 'Artikel berisi link promosi judi.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('article_reports', [
            'article_id' => $this->article->id,
            'user_id' => null,
            'reporter_name' => 'Budi Tamu',
            'reporter_email' => 'budi@example.com',
            'reason' => 'spam',
            'status' => 'pending',
        ]);

        Notification::assertSentTo($this->admin, ArticleReportedNotification::class);
    }

    public function test_duplicate_report_from_same_user_within_24_hours_is_prevented(): void
    {
        ArticleReport::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'spam',
            'status' => 'pending',
            'created_at' => now()->subHours(2),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('articles.report', $this->article->id), [
            'reason' => 'hate_speech',
            'details' => 'Mencoba melaporkan lagi.',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_admin_can_view_reports_index_and_stats(): void
    {
        ArticleReport::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'spam',
            'details' => 'Iklan obat tidak jelas',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Konten');
        $response->assertSee('Judul Artikel Kontroversial');
        $response->assertSee('Iklan obat tidak jelas');
    }

    public function test_admin_can_resolve_report_and_unpublish_article(): void
    {
        $report = ArticleReport::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'hate_speech',
            'details' => 'Pelanggaran serius',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.reports.status', $report), [
            'status' => 'resolved',
            'admin_notes' => 'Artikel telah ditarik ke status draft untuk diperiksa lebih lanjut.',
            'article_action' => 'unpublish',
        ]);

        $response->assertSessionHas('success');

        $report->refresh();
        $this->assertEquals('resolved', $report->status);
        $this->assertEquals($this->admin->id, $report->reviewed_by);
        $this->assertNotNull($report->reviewed_at);

        $this->article->refresh();
        $this->assertEquals('draft', $this->article->status);
    }

    public function test_admin_can_dismiss_report(): void
    {
        $report = ArticleReport::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'other',
            'details' => 'Laporan tidak berdasar',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.reports.status', $report), [
            'status' => 'dismissed',
            'admin_notes' => 'Tidak ditemukan pelanggaran.',
            'article_action' => 'none',
        ]);

        $response->assertSessionHas('success');

        $report->refresh();
        $this->assertEquals('dismissed', $report->status);
        $this->article->refresh();
        $this->assertEquals('published', $this->article->status);
    }

    public function test_admin_can_delete_report(): void
    {
        $report = ArticleReport::create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'reason' => 'spam',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.reports.destroy', $report));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('article_reports', ['id' => $report->id]);
    }

    public function test_article_detail_page_displays_options_menu_with_report_modal(): void
    {
        $response = $this->get(route('articles.show', $this->article->slug));
        $response->assertStatus(200);
        $response->assertSee('Laporkan Artikel');
        $response->assertSee('Salin Tautan Artikel');
    }

    public function test_dashboard_displays_pedoman_komunitas_and_panduan_menulis(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Pedoman Komunitas');
        $response->assertSee('Panduan Menulis');
    }
}
