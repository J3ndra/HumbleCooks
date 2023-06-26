<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        // $item = $request->search;
        // $ingr = Ingredient::where('name','LIKE',"%$item%")->get();
        $search = $request->input('search');

        $query = Ingredient::query();

        if ($search) {
            $query->where('ingredients.name', 'like', '%' . $search . '%');
        }

        $ingredients = $query->paginate(5);

        return view('home', [
            'ingredients' => $ingredients
        ]);
    }
}
