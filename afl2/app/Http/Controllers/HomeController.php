<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru
        $featured = Product::latest()->take(4)->get();

        // Ambil semua layanan
        $services = Service::all();

        return view('home', compact('featured', 'services'));
    }
}
