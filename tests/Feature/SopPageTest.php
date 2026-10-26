<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SopPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_sop_page_can_be_rendered(): void
    {
        $response = $this->get(route('sop'));

        $response->assertStatus(200);
        $response->assertSee('Standar Operasional Pelayanan');
        $response->assertSee('Legalisir Ijazah');
        $response->assertSee('Janji Temu');
        $response->assertSee('Surat Keterangan Siswa Aktif');
        $response->assertSee('Mutasi Siswa');
        $response->assertSee('target="_blank"', false);
    }

    public function test_standar_pelayanan_redirects_to_sop(): void
    {
        $response = $this->get('/standar-pelayanan');

        $response->assertRedirect('/sop');
    }
}
