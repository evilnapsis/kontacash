<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Movement;
use App\Models\PaymentMethod;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MovementController extends Controller
{
    public function index(Request $request): View
    {
        $kind = $request->query('kind');
        $accountId = $request->query('account_id');
        $search = trim((string) $request->query('q', ''));

        $query = Movement::with(['category', 'account', 'paymentMethod', 'person', 'user']);

        if (in_array((int) $kind, [Movement::KIND_INCOME, Movement::KIND_EXPENSE], true)) {
            $query->where('kind', (int) $kind);
        }

        if ($accountId) {
            $query->where('account_id', (int) $accountId);
        }

        if ($search !== '') {
            $query->where('description', 'like', "%{$search}%");
        }

        $movements = $query
            ->latest('movement_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $accounts = Account::orderBy('name')->get();
        $categories = Category::orderBy('kind')->orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();
        $people = Person::orderBy('name')->get();

        return view('movements.index', compact(
            'movements',
            'accounts',
            'categories',
            'paymentMethods',
            'people',
            'kind',
            'accountId',
            'search'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateMovement($request);
        $data['user_id'] = Auth::id();

        Movement::create($data);

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento registrado correctamente.');
    }

    public function edit(Movement $movement): View
    {
        $accounts = Account::orderBy('name')->get();
        $categories = Category::orderBy('kind')->orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();
        $people = Person::orderBy('name')->get();

        return view('movements.edit', compact(
            'movement',
            'accounts',
            'categories',
            'paymentMethods',
            'people'
        ));
    }

    public function update(Request $request, Movement $movement): RedirectResponse
    {
        $movement->update($this->validateMovement($request));

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento actualizado.');
    }

    public function destroy(Movement $movement): RedirectResponse
    {
        $movement->delete();

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento eliminado.');
    }

    private function validateMovement(Request $request): array
    {
        return $request->validate([
            'kind' => ['required', 'integer', 'in:1,2'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'movement_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:category,id'],
            'payment_method_id' => ['required', 'exists:payment_method,id'],
            'account_id' => ['required', 'exists:account,id'],
            'person_id' => ['nullable', 'exists:person,id'],
        ], [
            'kind.required' => 'Selecciona el tipo de movimiento.',
            'amount.required' => 'El monto es obligatorio.',
            'amount.min' => 'El monto debe ser mayor a 0.',
            'movement_date.required' => 'La fecha es obligatoria.',
            'description.required' => 'La descripción es obligatoria.',
            'category_id.required' => 'Selecciona una categoría.',
            'payment_method_id.required' => 'Selecciona una forma de pago.',
            'account_id.required' => 'Selecciona una cuenta.',
        ]);
    }
}
