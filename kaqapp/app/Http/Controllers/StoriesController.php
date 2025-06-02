<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class StoriesController extends Controller
{
    public function story1()
    {
        return view('story1');
    }

    public function story2()
    {
        return view('story2');
    }

    public function story3()
    {
        return view('story3');
    }
}