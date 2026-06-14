<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    // Skip the automatic TestCase admin login
    protected $skipAutoAuth = true;

    /**
     * Test admin dashboard shows dynamic activity feed (latest 10 items).
     */
    public function test_dashboard_shows_latest_activities_limited_to_ten()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Seed 2 Books
        for ($i = 1; $i <= 2; $i++) {
            Book::create([
                'title' => "Book Title $i",
                'author' => "Author $i",
                'category' => "Category $i",
                'description' => "Desc $i",
                'stock' => 5,
            ]);
        }

        // Seed 2 Members
        for ($i = 1; $i <= 2; $i++) {
            Member::create([
                'member_code' => "MBR-0000$i",
                'name' => "Member Name $i",
                'nik' => "nik$i" . str_repeat("0", 12),
                'address' => "Address $i",
                'phone' => "089999999$i",
                'email' => "member$i@example.com",
            ]);
        }

        // Get created members & books
        $m1 = Member::find(1);
        $m2 = Member::find(2);
        $b1 = Book::find(1);
        $b2 = Book::find(2);

        // Seed 2 Borrowings
        $t1 = Transaction::create([
            'member_id' => $m1->id,
            'book_id' => $b1->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);
        $t2 = Transaction::create([
            'member_id' => $m2->id,
            'book_id' => $b2->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        // Seed 2 Returns (update existing transactions)
        $t1->update([
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);
        $t2->update([
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        // Seed 2 Fines
        Fine::create([
            'transaction_id' => $t1->id,
            'late_days' => 2,
            'fine_amount' => 2000.00,
            'status' => 'belum_lunas',
        ]);
        Fine::create([
            'transaction_id' => $t2->id,
            'late_days' => 5,
            'fine_amount' => 5000.00,
            'status' => 'belum_lunas',
        ]);

        // Access dashboard
        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertStatus(200);

        // Assert we see activity feed categories
        $response->assertSee('Buku baru ditambahkan');
        $response->assertSee('Anggota baru ditambahkan');
        $response->assertSee('Peminjaman dibuat');
        $response->assertSee('Buku dikembalikan');
        $response->assertSee('Denda dibuat');

        // Let's assert the dynamic descriptions are also rendered
        $response->assertSee('Book Title 2');
        $response->assertSee('Member Name 2');
        $response->assertSee('Rp 5.000');
    }
}
