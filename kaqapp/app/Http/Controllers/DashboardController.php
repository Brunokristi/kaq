<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QrCodeType;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Fetch all QR code types
        $types = QrCodeType::all();

        // Pass both variables to the view
        return view('dashboard', compact('categories', 'types'));
    }
}