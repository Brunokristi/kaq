<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QrCodeType;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $types = QrCodeType::all();

        return view('dashboard', compact('categories', 'types'));
    }
}