<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WargaFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Siswa']);
        Role::firstOrCreate(['name' => 'Guru']);
        Role::firstOrCreate(['name' => 'Alumni']);

        $this->user = User::factory()->create([
            'email_verified_at' => now(),
            'role_type' => 'siswa',
            'is_active' => true,
        ]);
        $this->user->assignRole('Siswa');

        $this->category = Category::create([
            'name' => 'Karya Siswa',
            'slug' => 'karya-siswa',
            'type' => 'suara_warga',
        ]);
    }

    public function test_warga_can_view_articles_index_and_create_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('warga.articles.index'));
        $response->assertStatus(200);
        $response->assertSee('Karya Tulis Saya');

        $response = $this->actingAs($this->user)->get(route('warga.articles.create'));
        $response->assertStatus(200);
        $response->assertSee('Tulis Karya Suara Warga');
    }

    public function test_warga_can_store_and_edit_article(): void
    {
        $response = $this->actingAs($this->user)->post(route('warga.articles.store'), [
            'title' => 'Menulis Esai Kreatif',
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan esai singkat.',
            'content' => 'Ini adalah isi lengkap artikel esai kreatif yang sangat inspiratif dan bermanfaat bagi seluruh siswa dan pembaca di sekolah tercinta SMAN 1 Malingping.',
        ]);

        $response->assertRedirect(route('warga.articles.index'));
        $this->assertDatabaseHas('articles', [
            'user_id' => $this->user->id,
            'title' => 'Menulis Esai Kreatif',
            'status' => 'pending_review',
        ]);

        $article = Article::where('title', 'Menulis Esai Kreatif')->first();

        $editResponse = $this->actingAs($this->user)->get(route('warga.articles.edit', $article->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Perbarui Karya Tulis');
    }

    public function test_warga_can_delete_article(): void
    {
        $article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Akan Dihapus',
            'slug' => 'artikel-akan-dihapus',
            'content' => 'Konten artikel yang akan diuji untuk penghapusan.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->user)->delete(route('warga.articles.destroy', $article->id));
        $response->assertRedirect(route('warga.articles.index'));
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_warga_can_view_and_delete_comments_on_own_article(): void
    {
        $article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Dengan Komentar',
            'slug' => 'artikel-dengan-komentar',
            'content' => 'Konten artikel untuk komentar.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $comment = Comment::create([
            'article_id' => $article->id,
            'author_name' => 'Budi Pengunjung',
            'author_email' => 'budi@example.com',
            'content' => 'Tulisan yang sangat bagus!',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)->get(route('warga.comments.index'));
        $response->assertStatus(200);
        $response->assertSee('Komentar Pembaca');
        $response->assertSee('Budi Pengunjung');
        $response->assertSee('Tulisan yang sangat bagus!');

        $deleteResponse = $this->actingAs($this->user)->delete(route('warga.comments.destroy', $comment->id));
        $deleteResponse->assertRedirect(route('warga.comments.index'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_guest_comment_is_pending_and_can_be_approved_by_author(): void
    {
        $article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Uji Moderasi',
            'slug' => 'artikel-uji-moderasi',
            'content' => 'Konten untuk menguji sistem moderasi bertingkat.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Guest post comment
        $response = $this->post(route('articles.comment', $article->id), [
            'author_name' => 'Tamu Luar',
            'author_email' => 'tamu@example.com',
            'content' => 'Komentar dari pengunjung umum.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'author_name' => 'Tamu Luar',
            'status' => 'pending',
        ]);

        $pendingComment = Comment::where('author_name', 'Tamu Luar')->first();

        // Author of article approves the comment
        $approveResponse = $this->actingAs($this->user)->patch(route('warga.comments.approve', $pendingComment->id));
        $approveResponse->assertRedirect(route('warga.comments.index'));

        $this->assertDatabaseHas('comments', [
            'id' => $pendingComment->id,
            'status' => 'approved',
        ]);
    }

    public function test_authenticated_user_comment_is_instantly_approved(): void
    {
        $article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Artikel Warga Sekolah',
            'slug' => 'artikel-warga-sekolah',
            'content' => 'Konten artikel untuk komentar pengguna terdaftar.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Logged-in warga posts comment
        $response = $this->actingAs($this->user)->post(route('articles.comment', $article->id), [
            'content' => 'Komentar dari sesama warga terdaftar.',
        ]);

        $response->assertSessionHas('success', 'Komentar Anda berhasil dikirim.');
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'user_id' => $this->user->id,
            'status' => 'approved',
        ]);
    }

    public function test_warga_can_manage_testimonials(): void
    {
        $alumniUser = User::factory()->create([
            'email_verified_at' => now(),
            'role_type' => 'alumni',
            'is_active' => true,
        ]);
        $alumniUser->assignRole('Alumni');

        $response = $this->actingAs($alumniUser)->get(route('warga.testimonials.index'));
        $response->assertStatus(200);
        $response->assertSee('Testimoni Alumni');

        $storeResponse = $this->actingAs($alumniUser)->post(route('warga.testimonials.store'), [
            'role_subtitle' => 'Alumni 2021 • Mahasiswa ITB',
            'content' => 'SMAN 1 Malingping sangat berjasa dalam mempersiapkan saya masuk perguruan tinggi.',
        ]);

        $storeResponse->assertRedirect(route('warga.testimonials.index'));
        $this->assertDatabaseHas('testimonials', [
            'user_id' => $alumniUser->id,
            'role_subtitle' => 'Alumni 2021 • Mahasiswa ITB',
        ]);

        $testi = Testimonial::where('user_id', $alumniUser->id)->first();

        // Alumni cannot edit testimonial (it is locked)
        $editResponse = $this->actingAs($alumniUser)->get(route('warga.testimonials.edit', $testi->id));
        $editResponse->assertRedirect(route('warga.testimonials.index'));
        $editResponse->assertSessionHas('warning');

        // Alumni cannot delete testimonial (it is locked)
        $deleteResponse = $this->actingAs($alumniUser)->delete(route('warga.testimonials.destroy', $testi->id));
        $deleteResponse->assertRedirect(route('warga.testimonials.index'));
        $deleteResponse->assertSessionHas('error');
        $this->assertDatabaseHas('testimonials', ['id' => $testi->id]);

        // Alumni cannot create a second testimonial (1-time limit)
        $secondStore = $this->actingAs($alumniUser)->post(route('warga.testimonials.store'), [
            'role_subtitle' => 'Alumni 2021 • Kedua',
            'content' => 'Testimoni kedua tidak boleh diizinkan.',
        ]);
        $secondStore->assertRedirect(route('warga.testimonials.index'));
        $secondStore->assertSessionHas('error');
        $this->assertEquals(1, $alumniUser->testimonials()->count());
    }

    public function test_warga_can_update_profile_information(): void
    {
        $response = $this->actingAs($this->user)->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('Informasi Pribadi');
        $response->assertSee('Terkunci');

        $updateResponse = $this->actingAs($this->user)->patch(route('profile.update'), [
            'name' => 'Nama Baru Siswa',
            'username' => 'siswa-baru-unik',
            'bio' => 'Saya suka membaca buku sains dan sejarah.',
            'nisn' => '0098765432',
            'kelas' => 'XII MIPA 2',
        ]);

        $updateResponse->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Nama Baru Siswa',
            'username' => 'siswa-baru-unik',
            'bio' => 'Saya suka membaca buku sains dan sejarah.',
            'nisn' => '0098765432',
            'kelas' => 'XII MIPA 2',
        ]);
    }

    public function test_warga_cannot_take_existing_username_and_gets_warning(): void
    {
        $otherUser = User::factory()->create([
            'username' => 'warga-lain',
            'email' => 'wargalain@example.com',
            'role_type' => 'siswa',
        ]);

        $updateResponse = $this->actingAs($this->user)->patch(route('profile.update'), [
            'name' => $this->user->name,
            'username' => 'warga-lain', // already taken!
        ]);

        $updateResponse->assertSessionHasErrors(['username']);
        $errors = session('errors')->get('username');
        $this->assertStringContainsString('sudah digunakan', $errors[0]);
    }

    public function test_warga_email_remains_locked_and_unchanged_on_profile_update(): void
    {
        $originalEmail = $this->user->email;

        $updateResponse = $this->actingAs($this->user)->patch(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'malicious_changed_email@example.com',
        ]);

        $updateResponse->assertRedirect(route('profile.edit'));
        $this->user->refresh();
        $this->assertEquals($originalEmail, $this->user->email);
    }

    public function test_warga_article_supports_html_format_and_renders_in_prose(): void
    {
        $htmlContent = '<h2>Pengantar Literasi</h2><p>Pendidikan merupakan <strong>kunci utama</strong> kesuksesan.</p><blockquote>Maju bersama SMAN 1 Malingping.</blockquote><p>Kunjungi <a href="https://sman1malingping.sch.id">website resmi</a> untuk info lebih lanjut.</p>';

        $response = $this->actingAs($this->user)->post(route('warga.articles.store'), [
            'title' => 'Artikel Berformat HTML Penuh',
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan singkat artikel.',
            'content' => $htmlContent,
        ]);

        $response->assertRedirect(route('warga.articles.index'));
        $response->assertSessionHas('success');

        $article = Article::where('title', 'Artikel Berformat HTML Penuh')->first();
        $this->assertNotNull($article);
        $this->assertEquals($htmlContent, $article->content);

        // Edit with HTML
        $newHtml = '<h2>Revisi Artikel</h2><p>Konten yang telah <em>diperbarui</em> dengan <strong>editor kaya</strong>.</p><ul><li>Poin 1</li><li>Poin 2</li></ul>';
        $editResponse = $this->actingAs($this->user)->put(route('warga.articles.update', $article->id), [
            'title' => 'Artikel Berformat HTML Diperbarui',
            'category_id' => $this->category->id,
            'content' => $newHtml,
        ]);

        $editResponse->assertRedirect(route('warga.articles.index'));
        $editResponse->assertSessionHas('success');

        $article->refresh();
        $this->assertEquals($newHtml, $article->content);
    }

    public function test_comment_submission_triggers_toast_success_flash_message(): void
    {
        $article = Article::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'type' => 'suara_warga',
            'title' => 'Diskusi Artikel Komentar',
            'slug' => 'diskusi-artikel-komentar',
            'content' => 'Isi artikel lengkap untuk diskusi bersama para siswa dan pembaca budiman sekalian.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // 1. Comment as registered user -> immediate approval with success flash (toast)
        $userResponse = $this->actingAs($this->user)->post(route('articles.comment', $article->id), [
            'content' => 'Komentar saya sebagai siswa terdaftar.',
        ]);
        $userResponse->assertRedirect();
        $userResponse->assertSessionHas('success', 'Komentar Anda berhasil dikirim.');

        // 2. Comment as guest -> pending moderation with friendly notice flash (toast)
        auth()->logout();
        $guestResponse = $this->post(route('articles.comment', $article->id), [
            'author_name' => 'Warga Tamu',
            'author_email' => 'tamu@example.com',
            'content' => 'Komentar saya sebagai pengunjung umum.',
        ]);
        $guestResponse->assertRedirect();
        $guestResponse->assertSessionHas('success', 'Komentar Anda telah diterima dan akan ditayangkan setelah disetujui oleh moderator atau penulis artikel.');
    }
}
