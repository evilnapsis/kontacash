<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        $paymentMethods = PaymentMethod::withCount('movements')->orderBy('name')->get();

        return view('payment-methods.index', compact('paymentMethods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
        ]);

        PaymentMethod::create($data);

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago creada.');
    }

    public function edit(PaymentMethod $paymentMethod): View
    {
        return view('payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $paymentMethod->update($data);

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago actualizada.');
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        if ($paymentMethod->movements()->exists()) {
            return back()->with('error', 'No se puede eliminar una forma de pago con movimientos asociados.');
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago eliminada.');
    }
}
