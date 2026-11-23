<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index(): View
    {
        $people = Person::withCount('movements')->orderBy('name')->get();

        return view('people.index', compact('people'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
        ]);

        Person::create($data);

        return redirect()->route('people.index')->with('success', 'Persona registrada.');
    }

    public function edit(Person $person): View
    {
        return view('people.edit', compact('person'));
    }

    public function update(Request $request, Person $person): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $person->update($data);

        return redirect()->route('people.index')->with('success', 'Persona actualizada.');
    }

    public function destroy(Person $person): RedirectResponse
    {
        $person->delete();

        return redirect()->route('people.index')->with('success', 'Persona eliminada.');
    }
}
