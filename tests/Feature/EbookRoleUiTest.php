<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EbookRoleUiTest extends TestCase
{
    use RefreshDatabase;

    // Skip the automatic TestCase admin login
    protected $skipAutoAuth = true;

    private function createDummyEbook()
    {
        return Ebook::create([
            'title' => 'Sample Ebook',
            'author' => 'Author Name',
            'category' => 'Technology',
            'description' => 'Ebook Description',
            'cover_image' => 'covers/sample.jpg',
            'pdf_file' => 'ebooks/sample.pdf',
        ]);
    }

    /**
     * Test admin user sees all CRUD buttons in E-Library views.
     */
    public function test_admin_sees_all_management_buttons()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ebook = $this->createDummyEbook();

        // 1. Index Page
        $responseIndex = $this->actingAs($admin)->get(route('ebooks.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Tambah Ebook');
        $responseIndex->assertSee('Edit');
        $responseIndex->assertSee('Delete');

        // 2. Show Page
        $responseShow = $this->actingAs($admin)->get(route('ebooks.show', $ebook->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Edit Ebook');
        $responseShow->assertSee('Delete Ebook');
    }

    /**
     * Test member user does not see management buttons but sees view/read/download buttons.
     */
    public function test_member_does_not_see_management_buttons()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $ebook = $this->createDummyEbook();

        // 1. Index Page
        $responseIndex = $this->actingAs($member)->get(route('ebooks.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertDontSee('Tambah Ebook');
        $responseIndex->assertDontSee('Edit');
        $responseIndex->assertDontSee('Delete');
        // Both roles see view/read/download
        $responseIndex->assertSee('Detail');
        $responseIndex->assertSee('Baca PDF');
        $responseIndex->assertSee('Download');

        // 2. Show Page
        $responseShow = $this->actingAs($member)->get(route('ebooks.show', $ebook->id));
        $responseShow->assertStatus(200);
        $responseShow->assertDontSee('Edit Ebook');
        $responseShow->assertDontSee('Delete Ebook');
        $responseShow->assertSee('Baca PDF di Browser');
        $responseShow->assertSee('Download PDF');
    }
}
