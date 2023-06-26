<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Receipt;
use App\Models\Tool;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        // $item = $request->search;
        // $ingr = Ingredient::where('name','LIKE',"%$item%")->get();
        $search = $request->input('search');

        $query = Receipt::query();

        if ($search) {
            $query->where('receipts.title', 'like', '%' . $search . '%');
        }

        $receipts = $query->paginate(5);

        return view('home', [
            'receipts' => $receipts
        ]);
    }

    public function create_receipt_view(): View
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $tools = Tool::all();

        return view('user.receipt.form', compact('categories', 'ingredients', 'tools'));
    }

    public function store_receipt(Request $request): RedirectResponse
    {
        return redirect()
            ->route('home')
            ->with('status', 'Receipt created successfully');
    }
}
