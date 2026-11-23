<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $accounts = Account::withBalance()->orderBy('name')->get();

        return view('accounts.index', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'initial_balance' => ['required', 'numeric'],
        ], [
            'name.required' => 'El nombre de la cuenta es obligatorio.',
            'initial_balance.required' => 'El saldo inicial es obligatorio.',
        ]);

        Account::create($data);

        return redirect()->route('accounts.index')->with('success', 'Cuenta creada.');
    }

    public function edit(Account $account): View
    {
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'initial_balance' => ['required', 'numeric'],
        ]);

        $account->update($data);

        return redirect()->route('accounts.index')->with('success', 'Cuenta actualizada.');
    }

    public function destroy(Account $account): RedirectResponse
    {
        if ($account->movements()->exists()) {
            return back()->with('error', 'No se puede eliminar una cuenta con movimientos asociados.');
        }

        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Cuenta eliminada.');
    }
}
