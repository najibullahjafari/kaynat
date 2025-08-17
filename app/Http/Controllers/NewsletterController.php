<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Send email to admin or save to DB as needed
        Mail::raw('New newsletter subscriber: ' . $request->email, function ($message) {
            $message->to('najib202020202020@email.com')
                ->subject('New Newsletter Subscriber');
        });

        return back()->with('success', 'Thank you for subscribing!');
    }
}
