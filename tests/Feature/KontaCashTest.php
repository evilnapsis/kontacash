<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Movement;
use App\Models\PaymentMethod;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KontaCashTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_register_route_does_not_exist(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $admin = User::factory()->create([
            'password' => 'secret123',
        ]);

        $this->get('/dashboard')->assertRedirect(route('login'));

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'secret123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->get('/dashboard')->assertOk()->assertSee('Resumen financiero');
    }

    public function test_movements_update_account_balance_correctly(): void
    {
        $admin = User::factory()->create();

        $account = Account::create([
            'name' => 'BBVA',
            'bank_name' => 'BBVA',
            'initial_balance' => 1000.00,
        ]);

        $incomeCategory = Category::create(['name' => 'Ventas', 'kind' => Category::KIND_INCOME]);
        $expenseCategory = Category::create(['name' => 'Renta', 'kind' => Category::KIND_EXPENSE]);
        $method = PaymentMethod::create(['name' => 'Transferencia']);
        $person = Person::create(['name' => 'Cliente Uno']);

        $this->actingAs($admin)->post(route('movements.store'), [
            'kind' => Movement::KIND_INCOME,
            'amount' => 500.00,
            'movement_date' => now()->format('Y-m-d'),
            'description' => 'Cobro factura',
            'category_id' => $incomeCategory->id,
            'payment_method_id' => $method->id,
            'account_id' => $account->id,
            'person_id' => $person->id,
        ])->assertRedirect(route('movements.index'));

        $this->actingAs($admin)->post(route('movements.store'), [
            'kind' => Movement::KIND_EXPENSE,
            'amount' => 200.00,
            'movement_date' => now()->format('Y-m-d'),
            'description' => 'Pago oficina',
            'category_id' => $expenseCategory->id,
            'payment_method_id' => $method->id,
            'account_id' => $account->id,
        ])->assertRedirect(route('movements.index'));

        $loadedAccount = Account::withBalance()->findOrFail($account->id);
        $this->assertSame(1300.0, $loadedAccount->balance);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('1,300.00')
            ->assertSee('Cobro factura')
            ->assertSee('Pago oficina');
    }
}
