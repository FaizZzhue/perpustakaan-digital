<?php

namespace Tests\Feature;

use App\Models\Ebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EbookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ebooks_and_search()
    {
        $ebook1 = Ebook::create([
            'title' => 'Mastering Laravel',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'description' => 'A guide to advanced Laravel.',
            'cover_image' => 'covers/laravel.jpg',
            'pdf_file' => 'ebooks/laravel.pdf',
        ]);

        $ebook2 = Ebook::create([
            'title' => 'Clean Code Book',
            'author' => 'Robert Martin',
            'category' => 'Software engineering',
            'description' => 'A handbook of agile craftsmanship.',
            'cover_image' => 'covers/cleancode.jpg',
            'pdf_file' => 'ebooks/cleancode.pdf',
        ]);

        // Access index without search
        $response = $this->get(route('ebooks.index'));
        $response->assertStatus(200);
        $response->assertSee('Mastering Laravel');
        $response->assertSee('Clean Code Book');

        // Search by title
        $response = $this->get(route('ebooks.index', ['search' => 'Mastering']));
        $response->assertStatus(200);
        $response->assertSee('Mastering Laravel');
        $response->assertDontSee('Clean Code Book');

        // Search by author
        $response = $this->get(route('ebooks.index', ['search' => 'Martin']));
        $response->assertStatus(200);
        $response->assertSee('Clean Code Book');
        $response->assertDontSee('Mastering Laravel');

        // Search by category
        $response = $this->get(route('ebooks.index', ['search' => 'engineering']));
        $response->assertStatus(200);
        $response->assertSee('Clean Code Book');
        $response->assertDontSee('Mastering Laravel');
    }

    public function test_can_show_ebook_creation_form()
    {
        $response = $this->get(route('ebooks.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Ebook');
    }

    public function test_can_store_ebook_with_file_uploads()
    {
        Storage::fake('public');

        $cover = UploadedFile::fake()->image('cover.jpg');
        $pdf = UploadedFile::fake()->create('ebook.pdf', 100, 'application/pdf');

        $response = $this->post(route('ebooks.store'), [
            'title' => 'Design Patterns',
            'author' => 'Gang of Four',
            'category' => 'Computer Science',
            'description' => 'Elements of Reusable Object-Oriented Software.',
            'cover_image' => $cover,
            'pdf_file' => $pdf,
        ]);

        $response->assertRedirect(route('ebooks.index'));

        $this->assertDatabaseHas('ebooks', [
            'title' => 'Design Patterns',
            'author' => 'Gang of Four',
            'category' => 'Computer Science',
        ]);

        $ebook = Ebook::first();
        $this->assertNotNull($ebook->cover_image);
        $this->assertNotNull($ebook->pdf_file);

        Storage::disk('public')->assertExists($ebook->cover_image);
        Storage::disk('public')->assertExists($ebook->pdf_file);
    }

    public function test_can_show_ebook_details()
    {
        $ebook = Ebook::create([
            'title' => 'Mastering Laravel',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'description' => 'A guide to advanced Laravel.',
            'cover_image' => 'covers/laravel.jpg',
            'pdf_file' => 'ebooks/laravel.pdf',
        ]);

        $response = $this->get(route('ebooks.show', $ebook->id));
        $response->assertStatus(200);
        $response->assertSee('Mastering Laravel');
        $response->assertSee('Taylor Otwell');
        $response->assertSee('A guide to advanced Laravel.');
    }

    public function test_can_read_pdf_inline()
    {
        Storage::fake('public');
        $pdf = UploadedFile::fake()->create('ebook.pdf', 100, 'application/pdf');
        $pdfPath = $pdf->store('ebooks', 'public');

        $ebook = Ebook::create([
            'title' => 'Mastering Laravel',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'description' => 'A guide to advanced Laravel.',
            'pdf_file' => $pdfPath,
        ]);

        $response = $this->get(route('ebooks.read', $ebook->id));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'inline; filename="' . basename($ebook->pdf_file) . '"');
    }

    public function test_can_download_pdf()
    {
        Storage::fake('public');
        $pdf = UploadedFile::fake()->create('ebook.pdf', 100, 'application/pdf');
        $pdfPath = $pdf->store('ebooks', 'public');

        $ebook = Ebook::create([
            'title' => 'Mastering Laravel',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'description' => 'A guide to advanced Laravel.',
            'pdf_file' => $pdfPath,
        ]);

        $response = $this->get(route('ebooks.download', $ebook->id));
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=' . basename($ebook->pdf_file));
    }

    public function test_can_update_ebook_and_clean_up_storage()
    {
        Storage::fake('public');

        $oldCover = UploadedFile::fake()->image('old_cover.jpg');
        $oldPdf = UploadedFile::fake()->create('old_ebook.pdf', 100, 'application/pdf');

        $oldCoverPath = $oldCover->store('covers', 'public');
        $oldPdfPath = $oldPdf->store('ebooks', 'public');

        $ebook = Ebook::create([
            'title' => 'Old Title',
            'author' => 'Old Author',
            'category' => 'Old Category',
            'description' => 'Old Description',
            'cover_image' => $oldCoverPath,
            'pdf_file' => $oldPdfPath,
        ]);

        $newCover = UploadedFile::fake()->image('new_cover.jpg');
        $newPdf = UploadedFile::fake()->create('new_ebook.pdf', 200, 'application/pdf');

        $response = $this->put(route('ebooks.update', $ebook->id), [
            'title' => 'New Title',
            'author' => 'New Author',
            'category' => 'New Category',
            'description' => 'New Description',
            'cover_image' => $newCover,
            'pdf_file' => $newPdf,
        ]);

        $response->assertRedirect(route('ebooks.index'));

        $this->assertDatabaseHas('ebooks', [
            'id' => $ebook->id,
            'title' => 'New Title',
            'author' => 'New Author',
            'category' => 'New Category',
            'description' => 'New Description',
        ]);

        $ebook->refresh();

        // Old files should be deleted
        Storage::disk('public')->assertMissing($oldCoverPath);
        Storage::disk('public')->assertMissing($oldPdfPath);

        // New files should exist
        Storage::disk('public')->assertExists($ebook->cover_image);
        Storage::disk('public')->assertExists($ebook->pdf_file);
    }

    public function test_can_delete_ebook_and_clean_up_storage()
    {
        Storage::fake('public');

        $cover = UploadedFile::fake()->image('cover.jpg');
        $pdf = UploadedFile::fake()->create('ebook.pdf', 100, 'application/pdf');

        $coverPath = $cover->store('covers', 'public');
        $pdfPath = $pdf->store('ebooks', 'public');

        $ebook = Ebook::create([
            'title' => 'Delete Me',
            'author' => 'Author',
            'category' => 'Category',
            'description' => 'Description',
            'cover_image' => $coverPath,
            'pdf_file' => $pdfPath,
        ]);

        $response = $this->delete(route('ebooks.destroy', $ebook->id));
        $response->assertRedirect(route('ebooks.index'));

        $this->assertDatabaseMissing('ebooks', [
            'id' => $ebook->id,
        ]);

        Storage::disk('public')->assertMissing($coverPath);
        Storage::disk('public')->assertMissing($pdfPath);
    }
}
