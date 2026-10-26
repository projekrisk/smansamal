<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTestimonialTest extends TestCase
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
            'name' => 'Admin Moderator',
            'email' => 'admin.moderator@test.sch.id',
            'role_type' => 'admin',
            'is_active' => true,
        ]);
        $this->admin->assignRole('Admin');

        $this->warga = User::factory()->create([
            'name' => 'Warga Pengirim',
            'email' => 'warga.pengirim@test.sch.id',
            'role_type' => 'siswa',
            'is_active' => true,
        ]);
        $this->warga->assignRole('Siswa');
    }

    public function test_non_admin_cannot_access_testimonials_management(): void
    {
        $response = $this->actingAs($this->warga)->get(route('admin.testimonials.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_guest_cannot_access_testimonials_management(): void
    {
        $response = $this->get(route('admin.testimonials.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_testimonials_index_with_pagination(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Testimonial::create([
                'user_id' => $this->warga->id,
                'name' => "Alumni {$i}",
                'role_subtitle' => "Lulusan 202{$i}",
                'content' => "Testimoni dan pesan inspiratif nomor {$i}",
                'is_approved' => $i % 2 === 0,
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('admin.testimonials.index'));
        $response->assertStatus(200);
        $response->assertSee('Testimoni Alumni');
        $response->assertSee('Alumni 15');
        // Page 1 contains 10 items (since pagination is 10)
        $this->assertEquals(10, $response->viewData('testimonials')->count());
        $this->assertEquals(15, $response->viewData('testimonials')->total());
    }

    public function test_admin_can_search_testimonials(): void
    {
        Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Andi Pratama',
            'role_subtitle' => 'Mahasiswa Teknik Informatika ITB',
            'content' => 'Belajar di SMA tercinta sangat berkesan dan membuka banyak jalan.',
            'is_approved' => true,
        ]);

        Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Citra Lestari',
            'role_subtitle' => 'Alumni 2021',
            'content' => 'Terima kasih bapak ibu guru yang hebat!',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.testimonials.index', ['q' => 'Pratama']));
        $response->assertStatus(200);
        $response->assertSee('Andi Pratama');
        $response->assertDontSee('Citra Lestari');

        $responseContent = $this->actingAs($this->admin)->get(route('admin.testimonials.index', ['q' => 'Terima kasih']));
        $responseContent->assertStatus(200);
        $responseContent->assertSee('Citra Lestari');
        $responseContent->assertDontSee('Andi Pratama');
    }

    public function test_admin_can_filter_testimonials_by_status(): void
    {
        Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Doni Approved',
            'role_subtitle' => 'Dokter Muda',
            'content' => 'Pengalaman berharga.',
            'is_approved' => true,
            'status' => 'approved',
        ]);

        Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Eka Pending',
            'role_subtitle' => 'Wirausahawan',
            'content' => 'Semangat berjuang.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        // Filter: Approved
        $approvedResponse = $this->actingAs($this->admin)->get(route('admin.testimonials.index', ['status' => 'approved']));
        $approvedResponse->assertStatus(200);
        $approvedResponse->assertSee('Doni Approved');
        $approvedResponse->assertDontSee('Eka Pending');

        // Filter: Pending
        $pendingResponse = $this->actingAs($this->admin)->get(route('admin.testimonials.index', ['status' => 'pending']));
        $pendingResponse->assertStatus(200);
        $pendingResponse->assertSee('Eka Pending');
        $pendingResponse->assertDontSee('Doni Approved');
    }

    public function test_admin_can_toggle_approval_status(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Fajar Santoso',
            'role_subtitle' => 'Alumni 2019',
            'content' => 'Semoga sekolah semakin maju.',
            'is_approved' => false,
        ]);

        // Toggle to approved
        $response = $this->actingAs($this->admin)->patch(route('admin.testimonials.toggle-approval', $testi->id));
        $response->assertRedirect();
        $this->assertTrue($testi->fresh()->is_approved);

        // Toggle back to pending
        $response2 = $this->actingAs($this->admin)->patch(route('admin.testimonials.toggle-approval', $testi->id));
        $response2->assertRedirect();
        $this->assertFalse($testi->fresh()->is_approved);
    }

    public function test_admin_can_delete_testimonial(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Gita Kirana',
            'role_subtitle' => 'Alumni 2022',
            'content' => 'Testimoni yang ingin dihapus.',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testi->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('testimonials', ['id' => $testi->id]);
    }

    public function test_admin_can_reject_testimonial_with_revision_notes(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Hendra Alumni',
            'role_subtitle' => 'Alumni 2018',
            'content' => 'Belajar di sini sangat menyenangkan.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.reject', $testi->id), [
            'rejection_reason' => 'Mohon sertakan nama universitas atau profesi terkini.',
        ]);

        $response->assertRedirect();
        $fresh = $testi->fresh();
        $this->assertFalse($fresh->is_approved);
        $this->assertEquals('rejected', $fresh->status);
        $this->assertEquals('Mohon sertakan nama universitas atau profesi terkini.', $fresh->rejection_reason);

        // Check rejection filter on admin index
        $adminIndex = $this->actingAs($this->admin)->get(route('admin.testimonials.index', ['status' => 'rejected']));
        $adminIndex->assertStatus(200);
        $adminIndex->assertSee('Hendra Alumni');
        $adminIndex->assertSee('Mohon sertakan nama universitas atau profesi terkini.');
    }

    public function test_admin_cannot_reject_testimonial_without_notes(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => 'Indah Alumni',
            'role_subtitle' => 'Alumni 2020',
            'content' => 'Testimoni santai.',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.reject', $testi->id), [
            'rejection_reason' => '',
        ]);

        $response->assertSessionHasErrors('rejection_reason');
    }

    public function test_warga_sees_rejection_notes_and_testimonial_is_locked(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => $this->warga->name,
            'role_subtitle' => 'Alumni 2017',
            'content' => 'Pesan testimoni awal.',
            'is_approved' => false,
            'status' => 'rejected',
            'rejection_reason' => 'Gunakan bahasa yang lebih sopan dan jelas.',
        ]);

        // 1. Warga views index and sees rejection note & locked status
        $indexResponse = $this->actingAs($this->warga)->get(route('warga.testimonials.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Ditolak Redaksi');
        $indexResponse->assertSee('Gunakan bahasa yang lebih sopan dan jelas.');
        $indexResponse->assertSee('Terkunci');

        // 2. Warga attempts edit -> redirected with warning because it is locked
        $editResponse = $this->actingAs($this->warga)->get(route('warga.testimonials.edit', $testi->id));
        $editResponse->assertRedirect(route('warga.testimonials.index'));
        $editResponse->assertSessionHas('warning');

        // 3. Warga attempts update -> redirected with error because it is locked
        $updateResponse = $this->actingAs($this->warga)->put(route('warga.testimonials.update', $testi->id), [
            'role_subtitle' => 'Alumni 2017 • Software Engineer',
            'content' => 'Pengalaman belajar di SMAN 1 Malingping sangat berkesan dan mendidik karakter.',
        ]);

        $updateResponse->assertRedirect(route('warga.testimonials.index'));
        $updateResponse->assertSessionHas('error');
        $fresh = $testi->fresh();
        $this->assertEquals('rejected', $fresh->status);
        $this->assertEquals('Gunakan bahasa yang lebih sopan dan jelas.', $fresh->rejection_reason);

        // 4. Warga attempts destroy -> redirected with error because it is locked
        $destroyResponse = $this->actingAs($this->warga)->delete(route('warga.testimonials.destroy', $testi->id));
        $destroyResponse->assertRedirect(route('warga.testimonials.index'));
        $destroyResponse->assertSessionHas('error');
        $this->assertDatabaseHas('testimonials', ['id' => $testi->id]);
    }

    public function test_testimonial_content_cannot_exceed_300_characters(): void
    {
        $longContent = str_repeat('Testimoni yang terlalu panjang ', 15); // > 400 chars

        $response = $this->actingAs($this->warga)->post(route('warga.testimonials.store'), [
            'role_subtitle' => 'Alumni 2020',
            'content' => $longContent,
        ]);

        $response->assertSessionHasErrors('content');

    }

    public function test_alumni_can_only_create_one_testimonial(): void
    {
        // 1. Create first testimonial
        $firstStore = $this->actingAs($this->warga)->post(route('warga.testimonials.store'), [
            'role_subtitle' => 'Alumni 2020',
            'content' => 'Testimoni pertama yang valid dan sah.',
        ]);
        $firstStore->assertRedirect(route('warga.testimonials.index'));
        $this->assertEquals(1, $this->warga->testimonials()->count());

        // 2. Attempt to view create form
        $createResponse = $this->actingAs($this->warga)->get(route('warga.testimonials.create'));
        $createResponse->assertRedirect(route('warga.testimonials.index'));
        $createResponse->assertSessionHas('warning');

        // 3. Attempt to store second testimonial via warga panel
        $secondStore = $this->actingAs($this->warga)->post(route('warga.testimonials.store'), [
            'role_subtitle' => 'Alumni 2020 • Kedua',
            'content' => 'Testimoni kedua seharusnya ditolak.',
        ]);
        $secondStore->assertRedirect(route('warga.testimonials.index'));
        $secondStore->assertSessionHas('error');
        $this->assertEquals(1, $this->warga->testimonials()->count());

        // 4. Attempt to store via public home modal while logged in
        $publicStore = $this->actingAs($this->warga)->post(route('testimonials.store'), [
            'name' => $this->warga->name,
            'graduation_year' => 2020,
            'current_role' => 'Wirausahawan',
            'content' => 'Testimoni via form publik juga harus ditolak.',
        ]);
        $publicStore->assertSessionHas('error');
        $this->assertEquals(1, $this->warga->testimonials()->count());
    }

    public function test_approving_testimonial_creates_database_notification_for_warga(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => $this->warga->name,
            'role_subtitle' => 'Alumni 2020',
            'content' => 'SMAN 1 Malingping sekolah terbaik pencetak insan berprestasi.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        $this->assertEquals(0, $this->warga->notifications()->count());

        $response = $this->actingAs($this->admin)->patch(route('admin.testimonials.toggle-approval', $testi->id));
        $response->assertRedirect();

        $this->warga->refresh();
        $this->assertEquals(1, $this->warga->notifications()->count());

        $notification = $this->warga->notifications()->first();
        $this->assertEquals('testimonial_approved', $notification->data['type']);
        $this->assertEquals('approved', $notification->data['status']);
        $this->assertEquals($testi->id, $notification->data['testimonial_id']);
        $this->assertEquals(route('warga.testimonials.index'), $notification->data['target_url']);
    }

    public function test_rejecting_testimonial_creates_database_notification_with_rejection_reason(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => $this->warga->name,
            'role_subtitle' => 'Alumni 2020',
            'content' => 'SMAN 1 Malingping sekolah terbaik pencetak insan berprestasi.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.reject', $testi->id), [
            'rejection_reason' => 'Mohon tambahkan tahun kelulusan dan profesi Anda saat ini.',
        ]);
        $response->assertRedirect();

        $this->warga->refresh();
        $this->assertEquals(1, $this->warga->notifications()->count());

        $notification = $this->warga->notifications()->first();
        $this->assertEquals('testimonial_rejected', $notification->data['type']);
        $this->assertEquals('rejected', $notification->data['status']);
        $this->assertEquals('Mohon tambahkan tahun kelulusan dan profesi Anda saat ini.', $notification->data['rejection_reason']);
        $this->assertEquals(route('warga.testimonials.index'), $notification->data['target_url']);

        // Test clicking notification marks as read and redirects to index page
        $readResponse = $this->actingAs($this->warga)->post(route('notifications.read', $notification->id));
        $readResponse->assertRedirect(route('warga.testimonials.index'));
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_guest_testimonial_does_not_fail_when_approved_or_rejected(): void
    {
        $guestTesti = Testimonial::create([
            'user_id' => null,
            'name' => 'Tamu Alumni',
            'role_subtitle' => 'Alumni 2010',
            'content' => 'Semoga SMAN 1 Malingping terus berkiprah.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        // Toggle approval
        $response = $this->actingAs($this->admin)->patch(route('admin.testimonials.toggle-approval', $guestTesti->id));
        $response->assertRedirect();
        $this->assertTrue($guestTesti->fresh()->is_approved);

        // Reject
        $rejectResponse = $this->actingAs($this->admin)->post(route('admin.testimonials.reject', $guestTesti->id), [
            'rejection_reason' => 'Data tidak lengkap.',
        ]);
        $rejectResponse->assertRedirect();
        $this->assertEquals('rejected', $guestTesti->fresh()->status);
    }

    public function test_testimonial_notifications_render_properly_in_warga_and_public_views(): void
    {
        $testi = Testimonial::create([
            'user_id' => $this->warga->id,
            'name' => $this->warga->name,
            'role_subtitle' => 'Alumni 2020',
            'content' => 'Testimoni alumni hebat.',
            'is_approved' => false,
            'status' => 'pending',
        ]);

        // Trigger rejection
        $this->actingAs($this->admin)->post(route('admin.testimonials.reject', $testi->id), [
            'rejection_reason' => 'Perbaiki penulisan nama instansi.',
        ]);

        // Warga views warga layout
        $response = $this->actingAs($this->warga)->get(route('warga.testimonials.index'));
        $response->assertStatus(200);
        $response->assertSee('Testimoni Anda ditolak redaksi:');
        $response->assertSee('Perbaiki penulisan nama instansi.');

        // Warga views public home
        $publicResponse = $this->actingAs($this->warga)->get(route('home'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Testimoni ditolak redaksi');
    }
}

