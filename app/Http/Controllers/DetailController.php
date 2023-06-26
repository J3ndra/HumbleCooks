<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //
    public function show($id)
    {
        // dd("TES");
        // Ambil data ingredient berdasarkan ID
        $ingredient = Ingredient::find($id);

        // Jika ingredient tidak ditemukan, bisa dihandle sesuai kebutuhan
        if (!$ingredient) {
            return abort(404);
        }

        // Kirim data ingredient ke tampilan detail.blade.php
        return view('detail', compact('ingredient'));
    }
}
