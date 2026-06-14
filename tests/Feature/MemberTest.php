<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_members()
    {
        $member = Member::create([
            'member_code' => 'MBR-00001',
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'address' => 'Test Address',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'status' => 'Aktif',
        ]);

        $response = $this->get(route('members.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('MBR-00001');
    }

    public function test_can_show_member_creation_form()
    {
        $response = $this->get(route('members.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Anggota');
    }

    public function test_can_store_member_with_auto_generated_fields()
    {
        Storage::fake('public');
        Http::fake([
            'https://api.qrserver.com/*' => Http::response('fake-qr-code-content', 200),
        ]);

        $response = $this->post(route('members.store'), [
            'name' => 'Jane Doe',
            'nik' => '9876543210987654',
            'email' => 'jane@example.com',
            'phone' => '08987654321',
            'address' => 'Another Address',
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect(route('members.index'));
        
        $this->assertDatabaseHas('members', [
            'name' => 'Jane Doe',
            'nik' => '9876543210987654',
            'email' => 'jane@example.com',
            'member_code' => 'MBR-00001', // Should auto-generate MBR-00001
        ]);

        $member = Member::first();
        $this->assertNotNull($member->qr_code);
        $this->assertNotNull($member->photo);
        Storage::disk('public')->assertExists($member->photo);
        Storage::disk('public')->assertExists($member->qr_code);
    }

    public function test_cannot_store_duplicate_email_or_nik()
    {
        Member::create([
            'member_code' => 'MBR-00001',
            'name' => 'Existing User',
            'nik' => '1111222233334444',
            'address' => 'Address 1',
            'phone' => '08111111111',
            'email' => 'existing@example.com',
        ]);

        // Try duplicate NIK
        $response1 = $this->post(route('members.store'), [
            'name' => 'New User',
            'nik' => '1111222233334444', // Duplicate
            'email' => 'new@example.com',
            'phone' => '08222222222',
            'address' => 'Address 2',
        ]);
        $response1->assertSessionHasErrors('nik');

        // Try duplicate Email
        $response2 = $this->post(route('members.store'), [
            'name' => 'New User 2',
            'nik' => '5555666677778888',
            'email' => 'existing@example.com', // Duplicate
            'phone' => '08333333333',
            'address' => 'Address 3',
        ]);
        $response2->assertSessionHasErrors('email');
    }

    public function test_can_update_member()
    {
        $member = Member::create([
            'member_code' => 'MBR-00001',
            'name' => 'Old Name',
            'nik' => '1234567890123456',
            'address' => 'Old Address',
            'phone' => '08123456789',
            'email' => 'old@example.com',
            'status' => 'Aktif',
        ]);

        $response = $this->put(route('members.update', $member->id), [
            'name' => 'New Name',
            'nik' => '1234567890123456', // unchanged NIK is allowed for self
            'email' => 'new@example.com',
            'phone' => '08999999999',
            'address' => 'New Address',
            'status' => 'Nonaktif',
        ]);

        $response->assertRedirect(route('members.index'));

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
            'status' => 'Nonaktif',
        ]);
    }

    public function test_can_soft_delete_member()
    {
        $member = Member::create([
            'member_code' => 'MBR-00001',
            'name' => 'To Be Deleted',
            'nik' => '1234567890123456',
            'address' => 'Address',
            'phone' => '08123456789',
            'email' => 'delete@example.com',
            'status' => 'Aktif',
        ]);

        $response = $this->delete(route('members.destroy', $member->id));
        $response->assertRedirect(route('members.index'));

        $this->assertSoftDeleted('members', [
            'id' => $member->id,
        ]);
    }
}
