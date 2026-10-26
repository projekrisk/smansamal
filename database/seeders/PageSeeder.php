<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => '<p>Kami menyambut baik segala pertanyaan, saran, aspirasi, dan komunikasi dari calon siswa, orang tua/wali murid, alumni, instansi mitra, serta masyarakat umum.</p>',
                'meta_description' => 'Kami menyambut baik segala pertanyaan, saran, aspirasi, dan komunikasi dari calon siswa, orang tua/wali murid, alumni, instansi mitra, serta masyarakat umum.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Profil Sekolah',
                'slug' => 'profil-sekolah',
                'content' => '<h2>Visi & Misi SMAN 1 Malingping</h2><p>Mewujudkan insan bertaqwa, berkarakter unggul, berprestasi global, serta berwawasan lingkungan.</p><h3>Sejarah Singkat</h3><p>SMA Negeri 1 Malingping berdiri sebagai garda terdepan pendidikan berkualitas di wilayah Banten Selatan.</p>',
                'meta_description' => 'Profil resmi, sejarah, visi misi, dan kepemimpinan SMA Negeri 1 Malingping.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Syarat & Ketentuan',
                'slug' => 'syarat-ketentuan',
                'content' => '<h2>1. Ketentuan Umum Penggunaan</h2><p>Portal resmi SMA Negeri 1 Malingping disediakan sebagai sarana informasi publik, warta kegiatan sekolah, serta wadah publikasi karya literasi dan opini bagi civitas akademika.</p><h2>2. Akun Warga & Pengecekan Data Identitas</h2><p>Seluruh akun siswa dan alumni melalui verifikasi identitas resmi.</p>',
                'meta_description' => 'Ketentuan umum, etika kepenulisan warta, dan verifikasi identitas di portal SMAN 1 Malingping.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '<h2>Kebijakan Privasi & Keamanan Data</h2><p>Kami menghormati dan berkomitmen melindungi kerahasiaan data pribadi civitas akademika dan pengunjung portal resmi SMA Negeri 1 Malingping.</p>',
                'meta_description' => 'Komitmen perlindungan data pribadi dan privasi pengunjung portal SMAN 1 Malingping.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Pedoman Komunitas',
                'slug' => 'pedoman-komunitas',
                'content' => '<h2>Nilai Dasar Komunitas</h2><p>Ruang interaksi sehat, santun, ilmiah, dan saling membangun bagi guru, siswa, serta alumni SMAN 1 Malingping.</p>',
                'meta_description' => 'Pedoman etika berkomentar, interaksi warga, dan literasi santun di portal sekolah.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Panduan Suara Warga',
                'slug' => 'panduan-suara-warga',
                'content' => '<h2>Panduan Menulis & Publikasi Karya</h2><p>Petunjuk praktis bagi siswa, guru, dan alumni untuk mempublikasikan artikel opini, esai, dan karya literasi di kanal Suara Warga.</p>',
                'meta_description' => 'Panduan lengkap cara menulis, kurasi, dan publikasi di kanal Suara Warga SMAN 1 Malingping.',
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'title' => 'Fasilitas & Sarana Prasarana',
                'slug' => 'fasilitas-sekolah',
                'content' => '<h2>Fasilitas Unggulan SMAN 1 Malingping</h2><p>Untuk mendukung proses pembelajaran bermutu, sekolah kami dilengkapi sarana prasarana modern seperti Laboratorium Sains Digital, Lab Komputer Berstandar Asesmen Nasional, Perpustakaan Literasi, Sarana Olahraga Terbuka, dan Masjid Sekolah.</p>',
                'meta_description' => 'Informasi lengkap sarana prasarana dan fasilitas pendukung belajar mengajar di SMAN 1 Malingping.',
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
