<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;


class ContactController extends Controller
{
    public function index()
    {
        // Show the contact page
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send the email
        Mail::to('brunokristian003@gmail.com')
            ->send(new ContactMessage($validated));

        return back()->with('success', 'Message sent successfully!');
    }
}
