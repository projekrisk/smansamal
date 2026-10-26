<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdSettingTest extends TestCase
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
        ]);
        $this->siswa->assignRole('Siswa');

        $this->category = Category::create([
            'name' => 'Prestasi',
            'slug' => 'prestasi',
            'type' => 'jurnal',
        ]);
    }

    public function test_non_admin_cannot_access_ad_settings(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('admin.ads.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_ad_settings_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.ads.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Iklan AdSense');
        $response->assertSee('Iklan In-Article');
        $response->assertSee('Iklan Di Bawah Berita');
    }

    public function test_admin_can_update_ad_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.ads.update'), [
            'ad_in_article_enabled' => '1',
            'ad_in_article_code' => '<div id="test-in-article-ad">AdSense Unit 1</div>',
            'ad_in_article_paragraph' => 2,
            'ad_bottom_article_enabled' => '1',
            'ad_bottom_article_code' => '<div id="test-bottom-ad">AdSense Unit 2</div>',
            'adsense_header_enabled' => '1',
            'adsense_header_code' => '<script id="adsense-client">console.log("adsense");</script>',
        ]);

        $response->assertRedirect(route('admin.ads.index'));
        $response->assertSessionHas('success');

        $this->assertTrue(Setting::getBool('ad_in_article_enabled'));
        $this->assertEquals('<div id="test-in-article-ad">AdSense Unit 1</div>', Setting::get('ad_in_article_code'));
        $this->assertEquals(2, (int) Setting::get('ad_in_article_paragraph'));
        $this->assertTrue(Setting::getBool('ad_bottom_article_enabled'));
        $this->assertEquals('<div id="test-bottom-ad">AdSense Unit 2</div>', Setting::get('ad_bottom_article_code'));
    }

    public function test_berita_detail_displays_image_caption_and_no_reading_time_below_news(): void
    {
        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Upacara Peringatan Hari Pendidikan',
            'slug' => 'upacara-peringatan-hari-pendidikan',
            'excerpt' => 'Keluarga besar SMAN 1 Malingping menyelenggarakan upacara bendera.',
            'content' => '<p>Paragraf pertama upacara bendera berlangsung khidmat.</p><p>Paragraf kedua dihadiri oleh seluruh dewan guru dan siswa.</p><p>Paragraf ketiga ditutup dengan doa bersama.</p>',
            'featured_image' => 'articles/upacara.jpg',
            'featured_image_mode' => 'normal',
            'featured_image_caption' => 'Dokumentasi apel akbar SMAN 1 Malingping di lapangan utama',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('berita.show', $article->slug));
        $response->assertStatus(200);

        // Harus menampilkan caption gambar
        $response->assertSee('Dokumentasi apel akbar SMAN 1 Malingping di lapangan utama');

        // Harus memiliki tombol/trigger preview gambar
        $response->assertSee('Lihat Penuh');
        $response->assertSee('imageModalOpen');

        // Menit baca TIDAK BOLEH muncul di bawah berita
        $response->assertDontSee('Menit Baca');
    }

    public function test_berita_detail_renders_ads_when_enabled(): void
    {
        Setting::set('ad_in_article_enabled', '1');
        Setting::set('ad_in_article_code', '<ins class="adsbygoogle in-article-unit-test"></ins>');
        Setting::set('ad_in_article_paragraph', '2');

        Setting::set('ad_bottom_article_enabled', '1');
        Setting::set('ad_bottom_article_code', '<ins class="adsbygoogle bottom-article-unit-test"></ins>');

        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Prestasi Juara Debat Nasional',
            'slug' => 'prestasi-juara-debat-nasional',
            'excerpt' => 'Tim debat SMAN 1 Malingping meraih prestasi gemilang.',
            'content' => '<p>Paragraf pertama tim berhasil menembus babak final.</p><p>Paragraf kedua argumentasi yang dibawakan sangat memukau dewan juri.</p><p>Paragraf ketiga piala diserahkan langsung oleh menteri.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('berita.show', $article->slug));
        $response->assertStatus(200);

        // Iklan in-article dan bottom-article harus tampil
        $response->assertSee('in-article-unit-test');
        $response->assertSee('bottom-article-unit-test');
    }

    public function test_berita_detail_hides_ads_when_disabled(): void
    {
        Setting::set('ad_in_article_enabled', '0');
        Setting::set('ad_in_article_code', '<ins class="adsbygoogle in-article-unit-test"></ins>');

        Setting::set('ad_bottom_article_enabled', '0');
        Setting::set('ad_bottom_article_code', '<ins class="adsbygoogle bottom-article-unit-test"></ins>');

        $article = Article::create([
            'user_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'type' => 'jurnal',
            'title' => 'Peringatan Hari Lingkungan Hidup',
            'slug' => 'peringatan-hari-lingkungan-hidup',
            'excerpt' => 'Aksi tanam seribu bibit pohon bakau.',
            'content' => '<p>Paragraf satu.</p><p>Paragraf dua.</p><p>Paragraf tiga.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('berita.show', $article->slug));
        $response->assertStatus(200);

        // Iklan TIDAK BOLEH tampil saat dinonaktifkan
        $response->assertDontSee('in-article-unit-test');
        $response->assertDontSee('bottom-article-unit-test');
    }
}
