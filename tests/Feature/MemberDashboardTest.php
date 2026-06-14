<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    // Skip the automatic TestCase admin login
    protected $skipAutoAuth = true;

    /**
     * Guest cannot access member dashboard (redirects to /login).
     */
    public function test_guest_cannot_access_member_dashboard()
    {
        $response = $this->get(route('member.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Admin cannot access member dashboard (redirects to admin dashboard).
     */
    public function test_admin_cannot_access_member_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('member.dashboard'));
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Member without matching member profile is shown name, role, and a notice.
     */
    public function test_member_without_profile_shows_warning_and_info()
    {
        $memberUser = User::factory()->create([
            'name' => 'John Without Profile',
            'email' => 'noprofile@example.com',
            'role' => 'member',
        ]);

        $response = $this->actingAs($memberUser)->get(route('member.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Member');
        $response->assertSee('John Without Profile');
        $response->assertSee('noprofile@example.com');
        $response->assertSee('Profil Anggota Belum Terhubung');
    }

    /**
     * Member with matching member profile is shown all statistics, profile card details, and tables.
     */
    public function test_member_with_profile_shows_details_and_statistics()
    {
        $email = 'john.member@example.com';

        $memberUser = User::factory()->create([
            'name' => 'John Member',
            'email' => $email,
            'role' => 'member',
        ]);

        $member = Member::create([
            'member_code' => 'MBR-99999',
            'name' => 'John Member Profile',
            'nik' => '9999888877776666',
            'address' => 'Bandung, Indonesia',
            'phone' => '08999999999',
            'email' => $email,
            'status' => 'Aktif',
            'qr_code' => 'qrcodes/MBR-99999.png',
            'photo' => 'members/profile.jpg',
        ]);

        // Create a book
        $book1 = Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Author A',
            'category' => 'Technology',
            'description' => 'Great Book',
            'stock' => 5,
        ]);

        $book2 = Book::create([
            'title' => 'Tailwind Design',
            'author' => 'Author B',
            'category' => 'Design',
            'description' => 'Cool Book',
            'stock' => 3,
        ]);

        // Create transactions
        // 1. Active borrow (dipinjam)
        $borrow1 = Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book1->id,
            'borrow_date' => now()->subDays(2)->toDateString(),
            'due_date' => now()->addDays(5)->toDateString(),
            'status' => 'dipinjam',
        ]);

        // 2. Overdue borrow (will be auto-updated to 'terlambat' by dashboard controller)
        $borrow2 = Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book2->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(3)->toDateString(),
            'status' => 'dipinjam', // passes due date
        ]);

        // 3. Borrow history (dikembalikan)
        $borrow3 = Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book1->id,
            'borrow_date' => now()->subDays(15)->toDateString(),
            'due_date' => now()->subDays(8)->toDateString(),
            'return_date' => now()->subDays(9)->toDateString(),
            'status' => 'dikembalikan',
        ]);

        // Create a paid fine
        $fine1 = Fine::create([
            'transaction_id' => $borrow3->id,
            'late_days' => 2,
            'fine_amount' => 2000.00,
            'status' => 'lunas',
            'paid_at' => now()->subDays(9),
        ]);

        $response = $this->actingAs($memberUser)->get(route('member.dashboard'));
        $response->assertStatus(200);

        // Assert profile information is seen
        $response->assertSee('MBR-99999');
        $response->assertSee('John Member Profile');
        $response->assertSee('08999999999');
        $response->assertSee('Aktif');

        // Assert borrowing statistics are seen
        // Active Borrowings count: 2 (1 is active, 1 overdue)
        // Total Borrowings count: 3
        // Late Borrowings count: 1
        $response->assertSee('Peminjaman Aktif');
        $response->assertSee('Total Peminjaman');
        $response->assertSee('Peminjaman Terlambat');

        // Assert fine statistics are seen
        // Total Fines: Rp 2.000
        // Unpaid Fines: Rp 0
        // Paid Fines: Rp 2.000
        $response->assertSee('Total Denda');
        $response->assertSee('Belum Dibayar');
        $response->assertSee('Sudah Dibayar');
        $response->assertSee('Rp 2.000');

        // Assert tables contain correct books and records
        $response->assertSee('Laravel Mastery');
        $response->assertSee('Tailwind Design');
        $response->assertSee('Dipinjam');
        $response->assertSee('Terlambat');
        $response->assertSee('Dikembalikan');
    }
}
