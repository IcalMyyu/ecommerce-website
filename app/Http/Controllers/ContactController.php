<?php

namespace App\Http\Controllers;

use App\Models\CustomerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Store a new customer report from the contact form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'message'    => 'required|string|min:10',
        ]);

        CustomerReport::create([
            'user_id' => Auth::id(),
            'name'    => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'   => $validated['email'],
            'message' => $validated['message'],
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your message has been sent to our team.');
    }
}
