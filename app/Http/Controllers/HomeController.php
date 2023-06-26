<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Receipt;
use Illuminate\Contracts\View\View;
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
        return view('user.receipt.form');
    }
}
