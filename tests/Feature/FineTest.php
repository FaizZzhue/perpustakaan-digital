<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FineTest extends TestCase
{
    use RefreshDatabase;

    protected $member;
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->member = Member::create([
            'member_code' => 'MBR-00001',
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'address' => 'Test Address',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'status' => 'Aktif',
        ]);

        $this->book = Book::create([
            'title' => 'Laravel Guide',
            'author' => 'Taylor Otwell',
            'category' => 'Technology',
            'stock' => 5,
        ]);
    }

    public function test_can_list_fines()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(5)->toDateString(),
            'status' => 'dipinjam',
        ]);

        $fine = Fine::create([
            'transaction_id' => $transaction->id,
            'late_days' => 5,
            'fine_amount' => 5000.00,
            'status' => 'belum_lunas',
        ]);

        $response = $this->get(route('fines.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Rp 5.000');
        $response->assertSee('Belum Lunas');
    }

    public function test_returning_book_late_automatically_creates_fine()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(5)->toDateString(), // 5 days late today
            'status' => 'dipinjam',
        ]);

        $this->book->decrement('stock');

        // Return the book today
        $response = $this->post(route('borrows.return', $transaction->id));

        $response->assertRedirect(route('borrows.index'));
        $response->assertSessionHasNoErrors();

        // Check if transaction return_date is updated
        $this->assertEquals(now()->toDateString(), $transaction->fresh()->return_date);

        // Check if fine is automatically created in DB
        $this->assertDatabaseHas('fines', [
            'transaction_id' => $transaction->id,
            'late_days' => 5,
            'fine_amount' => 5000.00,
            'status' => 'belum_lunas',
            'paid_at' => null,
        ]);
    }

    public function test_returning_book_on_time_does_not_create_fine()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(2)->toDateString(),
            'due_date' => now()->addDays(5)->toDateString(), // returned early/on-time
            'status' => 'dipinjam',
        ]);

        $this->book->decrement('stock');

        // Return the book today
        $response = $this->post(route('borrows.return', $transaction->id));

        $response->assertRedirect(route('borrows.index'));
        
        // Check DB: transaction updated but no fine record created
        $this->assertEquals(now()->toDateString(), $transaction->fresh()->return_date);
        $this->assertDatabaseEmpty('fines');
    }

    public function test_can_pay_fine()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(5)->toDateString(),
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        $fine = Fine::create([
            'transaction_id' => $transaction->id,
            'late_days' => 5,
            'fine_amount' => 5000.00,
            'status' => 'belum_lunas',
        ]);

        // Pay the fine
        $response = $this->post(route('fines.pay', $fine->id));

        $response->assertRedirect(route('fines.index'));
        $response->assertSessionHasNoErrors();

        // Check status updated and paid_at is set
        $updatedFine = $fine->fresh();
        $this->assertEquals('lunas', $updatedFine->status);
        $this->assertNotNull($updatedFine->paid_at);
    }

    public function test_can_view_fine_details()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(5)->toDateString(),
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        $fine = Fine::create([
            'transaction_id' => $transaction->id,
            'late_days' => 5,
            'fine_amount' => 5000.00,
            'status' => 'belum_lunas',
        ]);

        $response = $this->get(route('fines.show', $fine->id));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Laravel Guide');
        $response->assertSee('5 Hari');
        $response->assertSee('Rp 5.000');
    }
}
