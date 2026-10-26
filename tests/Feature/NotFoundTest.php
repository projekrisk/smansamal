<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotFoundTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that non-existent URL returns 404 with custom error page.
     */
    public function test_non_existent_page_renders_custom_404_view(): void
    {
        $response = $this->get('/halaman-yang-pasti-tidak-ada-'.uniqid());

        $response->assertStatus(404);
        $response->assertSee('Galat 404');
        $response->assertSee('Halaman yang Anda Cari Tidak Ditemukan');
        $response->assertSee('Kembali ke Beranda');
    }
}
