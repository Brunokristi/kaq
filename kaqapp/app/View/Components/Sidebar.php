<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::with('qrCodeTypes')->get();
    }

    public function render()
    {
        return view('components.sidebar', [
            'categories' => Category::with('qrCodeTypes')->get(),
        ]);
    }
}