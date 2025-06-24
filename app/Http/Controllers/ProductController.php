<?php

namespace App\Http\Controllers;

use App\Models\Plakat;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {   
        // Tambahkan filter pencarian jika ada
        $query = Plakat::where('status', true);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        $plakats = $query->orderBy('created_at', 'desc')->get();
        
        return view('produk', compact('plakats'));
    }
}