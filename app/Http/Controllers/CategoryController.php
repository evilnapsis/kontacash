<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('movements')->orderBy('kind')->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'kind' => ['required', 'integer', 'in:1,2'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'kind.required' => 'Selecciona si es ingreso o gasto.',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoría creada.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'kind' => ['required', 'integer', 'in:1,2'],
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->movements()->exists()) {
            return back()->with('error', 'No se puede eliminar una categoría con movimientos asociados.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada.');
    }
}
