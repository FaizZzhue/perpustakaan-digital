<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowTest extends TestCase
{
    use RefreshDatabase;

    protected $member;
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard test data
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

    public function test_can_list_borrowings()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        $response = $this->get(route('borrows.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Laravel Guide');
        $response->assertSee('Dipinjam');
    }

    public function test_can_show_borrow_creation_form()
    {
        $response = $this->get(route('borrows.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Peminjaman');
        $response->assertSee('Laravel Guide');
        $response->assertSee('John Doe');
    }

    public function test_can_store_borrowing_and_decrement_book_stock()
    {
        $response = $this->post(route('borrows.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertRedirect(route('borrows.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'status' => 'dipinjam',
        ]);

        // Check stock was decremented
        $this->assertEquals(4, $this->book->fresh()->stock);
    }

    public function test_cannot_store_borrowing_if_book_stock_is_zero()
    {
        $this->book->update(['stock' => 0]);

        $response = $this->post(route('borrows.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertSessionHasErrors('book_id');
        $this->assertDatabaseEmpty('transactions');
    }

    public function test_cannot_store_borrowing_if_member_is_nonactive()
    {
        $this->member->update(['status' => 'Nonaktif']);

        $response = $this->post(route('borrows.store'), [
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertSessionHasErrors('member_id');
        $this->assertDatabaseEmpty('transactions');
    }

    public function test_can_return_borrowed_book_and_increment_stock()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        // Mock decremented stock from previous borrow
        $this->book->decrement('stock');
        $this->assertEquals(4, $this->book->fresh()->stock);

        $response = $this->post(route('borrows.return', $transaction->id));

        $response->assertRedirect(route('borrows.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        // Check stock was incremented
        $this->assertEquals(5, $this->book->fresh()->stock);
    }

    public function test_can_delete_borrowing_and_restore_stock_if_not_returned_yet()
    {
        $transaction = Transaction::create([
            'member_id' => $this->member->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        $this->book->decrement('stock');
        $this->assertEquals(4, $this->book->fresh()->stock);

        $response = $this->delete(route('borrows.destroy', $transaction->id));

        $response->assertRedirect(route('borrows.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id,
        ]);

        // Since it wasn't returned, stock should be restored to 5 on delete
        $this->assertEquals(5, $this->book->fresh()->stock);
    }
}
