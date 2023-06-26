<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $search = $request->input('search');

        $query = Ingredient::query();

        if ($sort === 'category') {
            $query
                ->join('categories', 'ingredients.category_id', '=', 'categories.id')
                ->select('ingredients.*', 'categories.name as category_name')
                ->orderBy('category_name')
                ->orderBy('ingredients.name');
        } elseif ($sort === 'name') {
            $query->orderBy('name');
        }

        if ($search) {
            $query->where('ingredients.name', 'like', '%' . $search . '%');
        }

        $ingredients = $query->paginate(10);

        return view('admin.ingredient.index', compact('ingredients', 'sort', 'search'));
    }

    public function edit($id)
    {
        $ingredient = Ingredient::find($id);
        $categories = Category::all();

        if (!$ingredient) {
            return redirect()
                ->route('dashboard.ingredient.index')
                ->with('status', 'Ingredient not found.');
        }

        return view('admin.ingredient.form', compact(['ingredient', 'categories']));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.ingredient.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'image' => 'required|image',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('ingredients', 'public');

        Ingredient::create([
            'name' => $validatedData['name'],
            'image' => $imagePath,
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category'],
        ]);

        return redirect()
            ->route('dashboard.ingredient.index')
            ->with('status', 'Ingredient created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
        ]);

        $ingredient = Ingredient::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($ingredient->image);

            $imagePath = $request->file('image')->store('ingredients', 'public');
            $ingredient->image = $imagePath;
        }

        $ingredient->name = $validatedData['name'];
        $ingredient->description = $validatedData['description'];
        $ingredient->category_id = $validatedData['category'];
        $ingredient->save();

        return redirect()
            ->route('dashboard.ingredient.index')
            ->with('status', 'Ingredient updated successfully.');
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        Storage::disk('public')->delete($ingredient->image);

        $ingredient->delete();

        return redirect()
            ->route('dashboard.ingredient.index')
            ->with('status', 'Ingredient deleted successfully.');
    }
}
