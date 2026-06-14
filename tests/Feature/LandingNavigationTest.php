<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingNavigationTest extends TestCase
{
    use RefreshDatabase;

    // Skip the automatic TestCase admin login
    protected $skipAutoAuth = true;

    /**
     * Test landing page has contact section.
     */
    public function test_landing_page_displays_contact_details()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Hubungi Kami');
        $response->assertSee('info@perpuspalembang.go.id');
        $response->assertSee('+62 711 356789');
        $response->assertSee('Jl. Demang Lebar Daun No. 9');
        $response->assertSee('FB');
        $response->assertSee('IG');
        $response->assertSee('TW');
        $response->assertSee('YT');
    }

    /**
     * Test guest accessing E-Library redirects to login page.
     */
    public function test_guest_accessing_elibrary_redirects_to_login()
    {
        $response = $this->get('/ebooks');
        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated member accessing E-Library succeeds.
     */
    public function test_authenticated_user_can_access_elibrary()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->get('/ebooks');
        $response->assertStatus(200);
    }
}
