<?php

namespace App\Http\Controllers;

use App\Models\Plakat;
use Illuminate\Http\Request;

class PlakatController extends Controller
{
    public function index()
    {
        $plakats = Plakat::where('status', true)->get();
        return view('produk', compact('plakats'));
    }
}