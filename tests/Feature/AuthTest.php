<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // Skip the automatic TestCase admin login to test different roles/guests
    protected $skipAutoAuth = true;

    public function test_guest_cannot_access_protected_admin_pages()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));

        $response2 = $this->get(route('books.index'));
        $response2->assertRedirect(route('login'));

        $response3 = $this->get(route('members.index'));
        $response3->assertRedirect(route('login'));

        $response4 = $this->get(route('borrows.index'));
        $response4->assertRedirect(route('login'));

        $response5 = $this->get(route('fines.index'));
        $response5->assertRedirect(route('login'));
    }

    public function test_admin_can_access_admin_pages()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertStatus(200);

        $response2 = $this->actingAs($admin)->get(route('books.index'));
        $response2->assertStatus(200);
    }

    public function test_member_cannot_access_admin_pages()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        // Attempting to access admin dashboard redirects to member dashboard
        $response = $this->actingAs($member)->get(route('dashboard'));
        $response->assertRedirect(route('member.dashboard'));

        // Attempting to access admin books page redirects to member dashboard
        $response2 = $this->actingAs($member)->get(route('books.index'));
        $response2->assertRedirect(route('member.dashboard'));
    }

    public function test_member_can_access_member_dashboard()
    {
        $member = User::factory()->create([
            'name' => 'Jane Member',
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->get(route('member.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Member');
        $response->assertSee('Jane Member');
        $response->assertSee('member');
    }

    public function test_both_roles_can_access_elibrary()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'member']);

        $responseAdmin = $this->actingAs($admin)->get(route('ebooks.index'));
        $responseAdmin->assertStatus(200);

        $responseMember = $this->actingAs($member)->get(route('ebooks.index'));
        $responseMember->assertStatus(200);
    }

    public function test_only_admin_can_modify_elibrary()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'member']);

        // Admin can access create form
        $responseAdmin = $this->actingAs($admin)->get(route('ebooks.create'));
        $responseAdmin->assertStatus(200);

        // Member gets redirected to member dashboard when trying to access Ebook create form
        $responseMember = $this->actingAs($member)->get(route('ebooks.create'));
        $responseMember->assertRedirect(route('member.dashboard'));
    }

    public function test_login_authenticates_and_redirects_correctly()
    {
        $admin = User::factory()->create([
            'email' => 'admin@perpus.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $member = User::factory()->create([
            'email' => 'member@perpus.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        // Test Admin login redirect
        $responseAdmin = $this->post(route('login'), [
            'email' => 'admin@perpus.com',
            'password' => 'password',
        ]);
        $responseAdmin->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);

        // Logout
        $this->post(route('logout'));

        // Test Member login redirect
        $responseMember = $this->post(route('login'), [
            'email' => 'member@perpus.com',
            'password' => 'password',
        ]);
        $responseMember->assertRedirect(route('member.dashboard'));

        $this->assertAuthenticatedAs($member);
    }

    public function test_logout_invalidates_session()
    {
        $member = User::factory()->create(['role' => 'member']);

        $this->actingAs($member);

        $response = $this->post(route('logout'));
        $response->assertRedirect('/');

        $this->assertGuest();
    }
}
