<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        $toEmail = config('mail.contact_email') ?? config('mail.from.address');

        Mail::to($toEmail)
            ->send(new ContactMail(
                name: $validated['name'],
                email: $validated['email'],
                phone: $validated['phone'] ?? 'Not provided',
                messageContent: $validated['message']
            ));

        return back()->with('success', 'Mesazhi u dërgua me sukses! Do t\'ju kontaktojmë së shpejti.');
    }
}
