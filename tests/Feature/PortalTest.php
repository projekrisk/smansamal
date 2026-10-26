<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Guru']);
        Role::firstOrCreate(['name' => 'Siswa']);
        Role::firstOrCreate(['name' => 'Alumni']);
    }

    public function test_homepage_loads_successfully_with_data(): void
    {
        $category = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi', 'type' => 'jurnal']);
        $user = User::factory()->create(['name' => 'Guru Penguji']);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'jurnal',
            'title' => 'Siswa Raih Medali Emas',
            'slug' => 'siswa-raih-medali-emas',
            'content' => '<p>Konten prestasi membanggakan.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SMAN 1');
        $response->assertSee('Siswa Raih Medali Emas');
    }

    public function test_jurnal_archive_page_loads_and_filters_by_category(): void
    {
        $cat1 = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi', 'type' => 'jurnal']);
        $cat2 = Category::create(['name' => 'Sains Ekologi', 'slug' => 'sains-ekologi', 'type' => 'jurnal']);
        $emptyCat = Category::create(['name' => 'Kategori Kosong Berita', 'slug' => 'kategori-kosong-berita', 'type' => 'jurnal']);
        $user = User::factory()->create();

        Article::create([
            'user_id' => $user->id,
            'category_id' => $cat1->id,
            'type' => 'jurnal',
            'title' => 'Prestasi Lomba Biologi',
            'slug' => 'prestasi-lomba-biologi',
            'content' => '<p>Konten 1</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $cat2->id,
            'type' => 'jurnal',
            'title' => 'Konservasi Mangrove Pesisir',
            'slug' => 'konservasi-mangrove-pesisir',
            'content' => '<p>Konten 2</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $responseAll = $this->get('/berita');
        $responseAll->assertStatus(200);
        $responseAll->assertSee('Prestasi Lomba Biologi');
        $responseAll->assertSee('Konservasi Mangrove Pesisir');
        $responseAll->assertSee('Prestasi');
        $responseAll->assertSee('Sains Ekologi');
        $responseAll->assertDontSee('Kategori Kosong Berita');

        $responseFiltered = $this->get('/berita?kategori=prestasi');
        $responseFiltered->assertStatus(200);
        $responseFiltered->assertSee('Prestasi Lomba Biologi');

        // Mengakses URL lama /jurnal diarahkan 301 ke /berita
        $redirectResponse = $this->get('/jurnal');
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/berita');

        $redirectQueryResponse = $this->get('/jurnal?kategori=prestasi');
        $redirectQueryResponse->assertStatus(301);
        $redirectQueryResponse->assertRedirect('/berita?kategori=prestasi');
    }

    public function test_suara_warga_archive_page_loads(): void
    {
        $cat = Category::create(['name' => 'Opini Siswa', 'slug' => 'opini-siswa', 'type' => 'suara_warga']);
        $emptyCat = Category::create(['name' => 'Kategori Kosong Warga', 'slug' => 'kategori-kosong-warga', 'type' => 'suara_warga']);
        $user = User::factory()->create(['name' => 'Nabila Maharani']);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Teknologi Bukan Pengganti Empati',
            'slug' => 'teknologi-bukan-pengganti-empati',
            'content' => '<p>Opini tentang literasi digital.</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/suara-warga');
        $response->assertStatus(200);
        $response->assertSee('Teknologi Bukan Pengganti Empati');
        $response->assertSee('Opini Siswa');
        $response->assertDontSee('Kategori Kosong Warga');
    }

    public function test_admin_sekolah_does_not_appear_in_active_authors_on_suara_warga(): void
    {
        $cat = Category::create(['name' => 'Karya Siswa', 'slug' => 'karya-siswa', 'type' => 'suara_warga']);

        $admin = User::factory()->create([
            'name' => 'Bapak Admin Pengelola',
            'role_type' => 'admin',
        ]);
        $admin->assignRole('Admin');

        $student = User::factory()->create([
            'name' => 'Ahmad Siswa Kreatif',
            'role_type' => 'siswa',
        ]);
        $student->assignRole('Siswa');

        // Admin article
        Article::create([
            'user_id' => $admin->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Tulisan Dari Admin',
            'slug' => 'tulisan-dari-admin',
            'content' => 'Konten artikel.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Student article
        Article::create([
            'user_id' => $student->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Puisi Dari Siswa',
            'slug' => 'puisi-dari-siswa',
            'content' => 'Konten puisi.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/suara-warga');
        $response->assertStatus(200);

        // Student must be seen in active authors
        $response->assertSee('Ahmad Siswa Kreatif');
        $response->assertSee('Siswa Aktif');

        // Admin must NOT appear in activeAuthors collection
        $this->assertFalse(
            $response->viewData('activeAuthors')->contains('id', $admin->id)
        );
        $this->assertTrue(
            $response->viewData('activeAuthors')->contains('id', $student->id)
        );
    }

    public function test_berita_archive_paginates_6_and_has_load_more_button(): void
    {
        $cat = Category::create(['name' => 'Akademik', 'slug' => 'akademik', 'type' => 'jurnal']);
        $user = User::factory()->create();

        for ($i = 1; $i <= 7; $i++) {
            Article::create([
                'user_id' => $user->id,
                'category_id' => $cat->id,
                'type' => 'jurnal',
                'title' => 'Berita Sekolah Ke-'.$i,
                'slug' => 'berita-sekolah-ke-'.$i,
                'content' => '<p>Konten berita '.$i.'</p>',
                'status' => 'published',
                'published_at' => now()->subMinutes(10 - $i),
            ]);
        }

        // Halaman awal memuat 6 artikel dan memiliki tombol Muat Lainnya serta tombol Back to Top
        $response = $this->get('/berita');
        $response->assertStatus(200);
        $response->assertSee('Muat Lainnya');
        $response->assertSee('btn-back-to-top');
        $response->assertSee('Kembali ke Atas');
        $response->assertSee('Berita Sekolah Ke-7'); // terbaru
        $response->assertDontSee('Berita Sekolah Ke-1'); // item ke-7 berada di page 2

        // AJAX request load more mengembalikan JSON halaman kedua
        $ajaxResponse = $this->get('/berita?page=2', ['X-Requested-With' => 'XMLHttpRequest']);
        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJsonStructure(['html', 'next_page_url', 'has_more', 'total']);
        $this->assertFalse($ajaxResponse->json('has_more'));
        $this->assertStringContainsString('Berita Sekolah Ke-1', $ajaxResponse->json('html'));
    }

    public function test_suara_warga_archive_paginates_6_and_has_load_more_button(): void
    {
        $cat = Category::create(['name' => 'Puisi', 'slug' => 'puisi', 'type' => 'suara_warga']);
        $user = User::factory()->create();

        for ($i = 1; $i <= 7; $i++) {
            Article::create([
                'user_id' => $user->id,
                'category_id' => $cat->id,
                'type' => 'suara_warga',
                'title' => 'Karya Puisi Ke-'.$i,
                'slug' => 'karya-puisi-ke-'.$i,
                'content' => '<p>Konten puisi '.$i.'</p>',
                'status' => 'published',
                'published_at' => now()->subMinutes(10 - $i),
            ]);
        }

        // Halaman awal memuat 6 artikel dan memiliki tombol Muat Lainnya serta tombol Back to Top
        $response = $this->get('/suara-warga');
        $response->assertStatus(200);
        $response->assertSee('Muat Lainnya');
        $response->assertSee('btn-back-to-top');
        $response->assertSee('Kembali ke Atas');

        // AJAX request load more mengembalikan JSON halaman kedua
        $ajaxResponse = $this->get('/suara-warga?page=2', ['X-Requested-With' => 'XMLHttpRequest']);
        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJsonStructure(['html', 'next_page_url', 'has_more', 'total']);
        $this->assertFalse($ajaxResponse->json('has_more'));
        $this->assertStringContainsString('Karya Puisi Ke-1', $ajaxResponse->json('html'));
    }

    public function test_article_detail_page_increments_views_and_renders_content(): void
    {
        $category = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi', 'type' => 'jurnal']);
        $user = User::factory()->create();

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'jurnal',
            'title' => 'Siswa Raih Medali Emas OSN',
            'slug' => 'siswa-raih-medali-emas-osn',
            'content' => '<p>Detail berita olimpiade sains.</p>',
            'status' => 'published',
            'views_count' => 10,
            'published_at' => now(),
        ]);

        // Jurnal/Berita diakses via /berita/{slug}
        $response = $this->get('/berita/'.$article->slug);
        $response->assertStatus(200);
        $response->assertSee('Siswa Raih Medali Emas OSN');

        $this->assertEquals(11, $article->fresh()->views_count);

        // Jika berita diakses via /artikel/{slug}, diarahkan 301 ke /berita/{slug}
        $redirectResponse = $this->get('/artikel/'.$article->slug);
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/berita/'.$article->slug);
    }

    public function test_user_can_toggle_like_on_article(): void
    {
        $category = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi', 'type' => 'jurnal']);
        $user = User::factory()->create();

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Menarik',
            'slug' => 'artikel-menarik',
            'content' => '<p>Konten menarik.</p>',
            'status' => 'published',
            'likes_count' => 0,
            'published_at' => now(),
        ]);

        $response = $this->postJson('/artikel/'.$article->id.'/like');
        $response->assertJson([
            'success' => true,
            'liked' => true,
            'likes_count' => 1,
        ]);
        $this->assertEquals(1, $article->fresh()->likes_count);

        // Toggle again (unlike)
        $response2 = $this->postJson('/artikel/'.$article->id.'/like');
        $response2->assertJson([
            'success' => true,
            'liked' => false,
            'likes_count' => 0,
        ]);
        $this->assertEquals(0, $article->fresh()->likes_count);
    }

    public function test_user_can_submit_comment(): void
    {
        $category = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi', 'type' => 'jurnal']);
        $user = User::factory()->create();

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'jurnal',
            'title' => 'Artikel Berprestasi',
            'slug' => 'artikel-berprestasi',
            'content' => '<p>Konten artikel.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->post('/artikel/'.$article->id.'/komentar', [
            'author_name' => 'Rina Gunawan',
            'author_email' => 'rina@gmail.com',
            'content' => 'Selamat atas prestasinya!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'author_name' => 'Rina Gunawan',
            'content' => 'Selamat atas prestasinya!',
        ]);
    }

    public function test_dynamic_registration_for_siswa(): void
    {
        $response = $this->post('/register', [
            'role_type' => 'siswa',
            'name' => 'Farhan Pratama',
            'email' => 'farhan@sman1malingping.sch.id',
            'nisn' => '0098765432',
            'kelas' => 'X MIPA 3',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/verify-email');
        $this->assertDatabaseHas('users', [
            'email' => 'farhan@sman1malingping.sch.id',
            'role_type' => 'siswa',
            'nisn' => '0098765432',
            'kelas' => 'X MIPA 3',
            'is_active' => false,
        ]);

        $user = User::where('email', 'farhan@sman1malingping.sch.id')->first();
        $this->assertTrue($user->hasRole('Siswa'));
    }

    public function test_admin_can_moderate_suara_warga(): void
    {
        $admin = User::factory()->create(['role_type' => 'admin']);
        $admin->assignRole('Admin');

        $siswa = User::factory()->create(['role_type' => 'siswa', 'is_active' => true]);
        $category = Category::create(['name' => 'Opini Siswa', 'slug' => 'opini-siswa', 'type' => 'suara_warga']);

        $article = Article::create([
            'user_id' => $siswa->id,
            'category_id' => $category->id,
            'type' => 'suara_warga',
            'title' => 'Menjaga Kebersihan Sungai',
            'slug' => 'menjaga-kebersihan-sungai',
            'content' => '<p>Konten esai siswa tentang lingkungan sungai sekitar.</p>',
            'status' => 'pending_review',
        ]);

        // Moderate approve
        $response = $this->actingAs($admin)->post('/admin/articles/'.$article->id.'/moderate', [
            'action' => 'approve',
        ]);

        $response->assertRedirect();
        $this->assertEquals('published', $article->fresh()->status);
        $this->assertNotNull($article->fresh()->published_at);
    }

    public function test_suara_warga_detail_and_canonical_redirect(): void
    {
        $cat = Category::create(['name' => 'Opini Siswa', 'slug' => 'opini-siswa', 'type' => 'suara_warga']);
        $user = User::factory()->create(['name' => 'Dimas Pratama']);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Merantau dan Belajar Memahami Kehidupan',
            'slug' => 'merantau-dan-belajar-memahami-kehidupan',
            'content' => '<p>Kuliah di luar kota mengajarkan saya banyak hal.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Suara warga diakses via /artikel/{slug}
        $response = $this->get('/artikel/'.$article->slug);
        $response->assertStatus(200);
        $response->assertSee('Merantau dan Belajar Memahami Kehidupan');
        $response->assertSee('Dilihat');

        // Jika suara warga diakses via /berita/{slug}, redirect 301 ke /artikel/{slug}
        $redirectResponse = $this->get('/berita/'.$article->slug);
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/artikel/'.$article->slug);
    }

    public function test_public_warga_profile_page_loads_with_articles(): void
    {
        $user = User::factory()->create([
            'name' => 'Dimas Pratama',
            'bio' => 'Mantan Ketua Ekstrakurikuler Jurnalistik SMAN 1 Malingping.',
            'role_type' => 'alumni',
            'tahun_lulus' => '2022',
            'pekerjaan_kampus' => 'Ilmu Komunikasi Universitas Indonesia',
        ]);
        $user->assignRole('Alumni');

        $cat = Category::create(['name' => 'Kisah Alumni', 'slug' => 'kisah-alumni', 'type' => 'suara_warga']);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Seni Mendengarkan Aktif dalam Diskusi Organisasi',
            'slug' => 'seni-mendengarkan-aktif',
            'content' => '<p>Pengalaman selama menjabat di kepengurusan OSIS.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'author_name' => $user->name,
            'content' => 'Komentar pertama pada artikel.',
            'status' => 'approved',
        ]);

        // 1. Akses via username
        $response = $this->get('/warga/'.$user->username);
        $response->assertStatus(200);
        $response->assertSee('Dimas Pratama');
        $response->assertSee('Alumni');
        $response->assertSee('Karya Tulis Dimas');
        $response->assertSee('Seni Mendengarkan Aktif dalam Diskusi Organisasi');
        // Memuat menu media sosial
        $response->assertSee('WhatsApp');
        $response->assertSee('Facebook');
        $response->assertSee('Telegram');
        // Memuat meta avatar user sebagai og:image
        $response->assertSee('ui-avatars.com');
        $response->assertSee('property="og:image"', false);

        // 2. Akses via numeric ID harus redirect 301 ke username
        $redirectResponse = $this->get('/warga/'.$user->id);
        $redirectResponse->assertStatus(301);
        $redirectResponse->assertRedirect('/warga/'.$user->username);

        // Memuat statistik Pengikut dan Dilihat
        $response->assertSee('Pengikut');
        $response->assertSee('Dilihat');
    }

    public function test_user_can_toggle_follow_warga_author(): void
    {
        $author = User::factory()->create(['name' => 'Penulis Populer']);
        $follower = User::factory()->create(['name' => 'Pembaca Setia']);

        $this->actingAs($follower);

        // 1. Follow author
        $followResponse = $this->postJson('/warga/'.$author->username.'/follow');
        $followResponse->assertStatus(200);
        $followResponse->assertJson([
            'success' => true,
            'following' => true,
            'followers_count' => 1,
        ]);
        $this->assertTrue($author->isFollowedBy($follower));

        // 2. Unfollow author
        $unfollowResponse = $this->postJson('/warga/'.$author->username.'/follow');
        $unfollowResponse->assertStatus(200);
        $unfollowResponse->assertJson([
            'success' => true,
            'following' => false,
            'followers_count' => 0,
        ]);
        $this->assertFalse($author->isFollowedBy($follower));
    }

    public function test_followers_receive_notification_when_author_publishes_article(): void
    {
        $author = User::factory()->create(['name' => 'Penulis Artikel']);
        $follower = User::factory()->create(['name' => 'Pengikut 1']);
        $cat = Category::create(['name' => 'Opini', 'slug' => 'opini', 'type' => 'suara_warga']);

        // Follow author
        $author->followers()->attach($follower->id);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        // Admin approve & publish author's article
        $article = Article::create([
            'user_id' => $author->id,
            'category_id' => $cat->id,
            'type' => 'suara_warga',
            'title' => 'Peran Literasi di Era Digital',
            'slug' => 'peran-literasi-di-era-digital',
            'content' => '<p>Konten literasi masa kini.</p>',
            'status' => 'pending_review',
        ]);

        $this->actingAs($admin);
        $moderateResponse = $this->post('/admin/articles/'.$article->id.'/moderate', [
            'action' => 'approve',
        ]);
        $moderateResponse->assertRedirect();

        // Verifikasi notifikasi masuk ke database follower
        $this->assertCount(1, $follower->fresh()->notifications);
        $notification = $follower->fresh()->notifications->first();
        $this->assertEquals('Peran Literasi di Era Digital', $notification->data['title']);
        $this->assertEquals($author->name, $notification->data['author_name']);

        // Test mark notification as read
        $this->actingAs($follower);
        $readResponse = $this->postJson('/notifikasi/'.$notification->id.'/read');
        $readResponse->assertStatus(200);
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_pedoman_komunitas_and_panduan_suara_warga_pages_load_successfully(): void
    {
        $responsePedoman = $this->get(route('pedoman-komunitas'));
        $responsePedoman->assertStatus(200);
        $responsePedoman->assertSee('Pedoman Komunitas');
        $responsePedoman->assertSee('Nilai Dasar Komunitas');

        $responsePanduan = $this->get(route('panduan-suara-warga'));
        $responsePanduan->assertStatus(200);
        $responsePanduan->assertSee('Panduan Penggunaan Kanal Suara Warga');
        $responsePanduan->assertSee('Daftar Isi Panduan');
        $responsePanduan->assertSee('Membuat Akun');
    }

    public function test_homepage_alumni_testimonial_name_links_to_public_profile(): void
    {
        $alumni = User::factory()->create([
            'name' => 'Budi Alumni SMAN1',
            'username' => 'budi-alumni-sman1',
            'role_type' => 'alumni',
            'tahun_lulus' => '2020',
            'pekerjaan_kampus' => 'Mahasiswa ITB',
            'is_active' => true,
        ]);
        $alumni->assignRole('Alumni');

        $testimonial = Testimonial::create([
            'user_id' => $alumni->id,
            'name' => $alumni->name,
            'role_subtitle' => 'Alumni 2020 • Mahasiswa ITB',
            'content' => 'Pendidikan luar biasa di SMAN 1 Malingping membawa saya menggapai cita-cita.',
            'is_approved' => true,
            'status' => 'approved',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $profileUrl = route('warga.profile', 'budi-alumni-sman1');
        $response->assertSee($profileUrl);
        $response->assertSee('Budi Alumni SMAN1');
        $response->assertSee('Alumni 2020 • Mahasiswa ITB');

        $profileResponse = $this->get($profileUrl);
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('Budi Alumni SMAN1');
        $profileResponse->assertSee('Angkatan 2020');
        $profileResponse->assertSee('Mahasiswa ITB');
    }

    public function test_seo_meta_tags_and_og_image_on_homepage(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('<meta property="og:site_name" content="SMA Negeri 1 Malingping">', false);
        $response->assertSee('images/og-default.jpg');
        $response->assertSee('Cageur, Bageur, Bener, Pinter');
        $response->assertSee('EducationalOrganization');
        $response->assertSee('20601836');
    }

    public function test_seo_fallback_image_and_schema_on_article(): void
    {
        $user = User::factory()->create(['name' => 'Guru Penulis']);
        $category = Category::create(['name' => 'Warta', 'slug' => 'warta', 'type' => 'jurnal']);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'type' => 'jurnal',
            'title' => 'Eksplorasi Sains Digital Siswa',
            'slug' => 'eksplorasi-sains-digital-siswa',
            'content' => '<p>Artikel riset tanpa gambar bawaan.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertStringContainsString('images/og-default.jpg', $article->featured_image_url);

        $response = $this->get(route('berita.show', $article->slug));
        $response->assertStatus(200);
        $response->assertSee('images/og-default.jpg');
        $response->assertSee('NewsArticle');
        $response->assertSee('Guru Penulis');
    }

    public function test_sitemap_xml_returns_valid_xml_structure(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('<urlset', false);
        $response->assertSee(route('home'));
        $response->assertSee(route('profil-sekolah'));
        $response->assertSee(route('contact'));
        $response->assertSee(route('berita.index'));
        $response->assertSee(route('suara-warga.index'));
    }

    public function test_icon_png_is_served_successfully(): void
    {
        $response = $this->get('/icon.png');
        $response->assertStatus(200);
        $this->assertStringContainsString('image/png', (string) $response->headers->get('Content-Type'));
    }

    public function test_security_headers_are_present_on_web_responses(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $this->assertNotNull($response->headers->get('Permissions-Policy'));
    }

    public function test_website_schema_has_search_action_and_sitelinks(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('WebSite');
        $response->assertSee('SearchAction');
        $response->assertSee('SiteNavigationElement');
        $response->assertSee('Profil Sekolah');
        $response->assertSee('dns-prefetch', false);
    }

    public function test_active_announcement_renders_on_public_pages(): void
    {
        $announcement = Announcement::create([
            'title' => 'Pemberitahuan Ujian Semester',
            'content' => 'Pelaksanaan ujian semester dimulai pekan depan.',
            'button_text' => 'Unduh Jadwal',
            'button_url' => 'https://sman1malingping.sch.id/jadwal',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pemberitahuan Ujian Semester');
        $response->assertSee('Pelaksanaan ujian semester dimulai pekan depan.');
        $response->assertSee('Unduh Jadwal');
        $response->assertSee('https://sman1malingping.sch.id/jadwal');

        $this->assertEquals(1, $announcement->fresh()->views_count);

        $apiResponse = $this->getJson('/api/pengumuman-aktif');
        $apiResponse->assertStatus(200);
        $apiResponse->assertJson([
            'active' => true,
            'title' => 'Pemberitahuan Ujian Semester',
        ]);
    }

    public function test_admin_can_manage_announcements(): void
    {
        $admin = User::factory()->create(['role_type' => 'admin']);
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)->post('/admin/announcements', [
            'title' => 'Pengumuman Libur Nasional',
            'content' => 'Seluruh kegiatan belajar mengajar diliburkan.',
            'button_text' => 'Surat Edaran',
            'button_url' => 'https://sman1malingping.sch.id/edaran',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/announcements');
        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Libur Nasional',
            'is_active' => true,
        ]);

        $announcement = Announcement::where('title', 'Pengumuman Libur Nasional')->first();

        // Toggle status
        $toggleResponse = $this->actingAs($admin)->patch('/admin/announcements/'.$announcement->id.'/toggle-status');
        $toggleResponse->assertRedirect();
        $this->assertFalse($announcement->fresh()->is_active);
    }

    public function test_draft_articles_cannot_be_viewed_or_accessed_by_public(): void
    {
        $catJurnal = Category::create(['name' => 'Warta Berita', 'slug' => 'warta-berita', 'type' => 'jurnal']);
        $catWarga = Category::create(['name' => 'Karya Warga', 'slug' => 'karya-warga', 'type' => 'suara_warga']);
        $author = User::factory()->create(['name' => 'Penulis Internal', 'username' => 'penulis-internal', 'role_type' => 'guru']);
        $author->assignRole('Guru');

        $draftJurnal = Article::create([
            'user_id' => $author->id,
            'category_id' => $catJurnal->id,
            'type' => 'jurnal',
            'title' => 'Draf Berita Rahasia Sekolah',
            'slug' => 'draf-berita-rahasia-sekolah',
            'content' => 'Konten internal belum boleh tayang.',
            'status' => 'draft',
            'published_at' => now(),
        ]);

        $draftSuaraWarga = Article::create([
            'user_id' => $author->id,
            'category_id' => $catWarga->id,
            'type' => 'suara_warga',
            'title' => 'Draf Suara Warga Belum Rilis',
            'slug' => 'draf-suara-warga-belum-rilis',
            'content' => 'Opini belum selesai disusun.',
            'status' => 'draft',
            'published_at' => now(),
        ]);

        // 1. Tidak muncul di beranda
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertDontSee('Draf Berita Rahasia Sekolah');
        $homeResponse->assertDontSee('Draf Suara Warga Belum Rilis');

        // 2. Tidak muncul di arsip berita
        $beritaResponse = $this->get('/berita');
        $beritaResponse->assertStatus(200);
        $beritaResponse->assertDontSee('Draf Berita Rahasia Sekolah');

        // 3. Tidak muncul di suara warga
        $suaraWargaResponse = $this->get('/suara-warga');
        $suaraWargaResponse->assertStatus(200);
        $suaraWargaResponse->assertDontSee('Draf Suara Warga Belum Rilis');

        // 4. Tidak muncul di profil publik penulis
        $profileResponse = $this->get('/warga/penulis-internal');
        $profileResponse->assertStatus(200);
        $profileResponse->assertDontSee('Draf Berita Rahasia Sekolah');
        $profileResponse->assertDontSee('Draf Suara Warga Belum Rilis');

        // 5. Tidak muncul di sitemap
        $sitemapResponse = $this->get('/sitemap.xml');
        $sitemapResponse->assertStatus(200);
        $sitemapResponse->assertDontSee('draf-berita-rahasia-sekolah');
        $sitemapResponse->assertDontSee('draf-suara-warga-belum-rilis');

        // 6. Akses URL publik langsung oleh tamu (tamu/guest/publik) menghasilkan 404
        $this->get('/berita/'.$draftJurnal->slug)->assertStatus(404);
        $this->get('/artikel/'.$draftSuaraWarga->slug)->assertStatus(404);

        // 7. Akses URL publik langsung oleh user biasa (siswa) menghasilkan 404
        $student = User::factory()->create(['role_type' => 'siswa']);
        $student->assignRole('Siswa');
        $this->actingAs($student)->get('/berita/'.$draftJurnal->slug)->assertStatus(404);
        $this->actingAs($student)->get('/artikel/'.$draftSuaraWarga->slug)->assertStatus(404);

        // 8. Endpoint interaksi (like, komentar, stats) menghasilkan 404 bagi publik
        $this->postJson('/artikel/'.$draftJurnal->id.'/like')->assertStatus(404);
        $this->getJson('/artikel/'.$draftJurnal->id.'/stats')->assertStatus(404);
        $this->post('/artikel/'.$draftJurnal->id.'/komentar', [
            'author_name' => 'Tamu',
            'content' => 'Komentar saya',
        ])->assertStatus(404);

        // 9. Administrator dapat melakukan pratinjau (preview) dengan banner peringatan
        $admin = User::factory()->create(['role_type' => 'admin']);
        $admin->assignRole('Admin');

        $adminBeritaResponse = $this->actingAs($admin)->get('/berita/'.$draftJurnal->slug);
        $adminBeritaResponse->assertStatus(200);
        $adminBeritaResponse->assertSee('Pratinjau Khusus');
        $adminBeritaResponse->assertSee('DRAF');

        $adminSuaraWargaResponse = $this->actingAs($admin)->get('/artikel/'.$draftSuaraWarga->slug);
        $adminSuaraWargaResponse->assertStatus(200);
        $adminSuaraWargaResponse->assertSee('Pratinjau Khusus');
        $adminSuaraWargaResponse->assertSee('DRAF');
    }
}
