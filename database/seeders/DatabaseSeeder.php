<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kontacash.com'],
            [
                'name' => 'Admin KontaCash',
                'password' => 'password',
            ]
        );

        $incomeCategories = ['Ventas', 'Servicios', 'Honorarios', 'Otros ingresos'];
        foreach ($incomeCategories as $name) {
            Category::firstOrCreate(['name' => $name, 'kind' => Category::KIND_INCOME]);
        }

        $expenseCategories = ['Nómina', 'Renta', 'Servicios', 'Insumos', 'Otros gastos'];
        foreach ($expenseCategories as $name) {
            Category::firstOrCreate(['name' => $name, 'kind' => Category::KIND_EXPENSE]);
        }

        $methods = ['Efectivo', 'Transferencia bancaria', 'Tarjeta de débito', 'Tarjeta de crédito'];
        foreach ($methods as $name) {
            PaymentMethod::firstOrCreate(['name' => $name]);
        }

        Account::firstOrCreate(
            ['name' => 'Caja Chica'],
            ['bank_name' => 'Efectivo', 'account_number' => null, 'initial_balance' => 5000.00]
        );

        Account::firstOrCreate(
            ['name' => 'Cuenta Principal'],
            ['bank_name' => 'BBVA', 'account_number' => '0123456789', 'initial_balance' => 25000.00]
        );

        Person::firstOrCreate(
            ['name' => 'Cliente General'],
            ['email' => 'cliente@ejemplo.com', 'phone' => '555-0100', 'notes' => 'Contacto inicial']
        );
    }
}
