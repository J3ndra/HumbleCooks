<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //
    public function show($id): View
    {
        // dd("TES");
        // Ambil data receipt berdasarkan ID
        $receipt = Receipt::find($id);

        // Jika receipt tidak ditemukan, bisa dihandle sesuai kebutuhan
        if (!$receipt) {
            return abort(404);
        }

        // Kirim data receipt ke tampilan detail.blade.php
        return view('user.receipt.detail', compact('receipt'));
    }
}
