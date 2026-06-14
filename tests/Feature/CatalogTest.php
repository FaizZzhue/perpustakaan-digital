<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_displays_latest_books()
    {
        // Create 6 books
        $books = collect();
        for ($i = 1; $i <= 6; $i++) {
            $books->push(Book::create([
                'title' => "Book Title {$i}",
                'author' => "Author {$i}",
                'category' => "Category {$i}",
                'stock' => 5,
            ]));
        }

        $response = $this->get(route('landing'));

        $response->assertStatus(200);
        // The landing page should show the 5 latest books (Book 6, 5, 4, 3, 2)
        $response->assertSee('Book Title 6');
        $response->assertSee('Book Title 5');
        $response->assertSee('Book Title 4');
        $response->assertSee('Book Title 3');
        $response->assertSee('Book Title 2');
        // Book 1 is older and outside the limit of 5
        $response->assertDontSee('Book Title 1');
    }

    public function test_can_search_books_by_title()
    {
        $book1 = Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'stock' => 10,
        ]);

        $book2 = Book::create([
            'title' => 'Clean Code',
            'author' => 'Robert Martin',
            'category' => 'Technology',
            'stock' => 5,
        ]);

        $response = $this->get(route('landing', ['search' => 'Mastery']));

        $response->assertStatus(200);
        $response->assertViewHas('searchResults', function ($results) use ($book1, $book2) {
            return $results->contains($book1) && !$results->contains($book2);
        });
    }

    public function test_can_search_books_by_author()
    {
        $book1 = Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'stock' => 10,
        ]);

        $book2 = Book::create([
            'title' => 'Clean Code',
            'author' => 'Robert Martin',
            'category' => 'Technology',
            'stock' => 5,
        ]);

        $response = $this->get(route('landing', ['search' => 'Martin']));

        $response->assertStatus(200);
        $response->assertViewHas('searchResults', function ($results) use ($book1, $book2) {
            return $results->contains($book2) && !$results->contains($book1);
        });
    }

    public function test_can_search_books_by_category()
    {
        $book1 = Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'stock' => 10,
        ]);

        $book2 = Book::create([
            'title' => 'Atomic Habits',
            'author' => 'James Clear',
            'category' => 'Self Improvement',
            'stock' => 5,
        ]);

        $response = $this->get(route('landing', ['search' => 'Improvement']));

        $response->assertStatus(200);
        $response->assertViewHas('searchResults', function ($results) use ($book1, $book2) {
            return $results->contains($book2) && !$results->contains($book1);
        });
    }

    public function test_can_view_public_book_details()
    {
        $book = Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'stock' => 10,
        ]);

        $response = $this->get(route('public.books.show', $book->id));

        $response->assertStatus(200);
        $response->assertSee('Laravel Mastery');
        $response->assertSee('Taylor Otwell');
        $response->assertSee('Technology');
        $response->assertSee('10 Eksemplar');
        $response->assertSee('Tersedia');
    }

    public function test_shows_out_of_stock_status_for_public_book()
    {
        $book = Book::create([
            'title' => 'Out of Stock Book',
            'author' => 'No Stock Author',
            'category' => 'Drama',
            'stock' => 0,
        ]);

        $response = $this->get(route('public.books.show', $book->id));

        $response->assertStatus(200);
        $response->assertSee('Out of Stock Book');
        $response->assertSee('Tidak Tersedia');
    }
}
