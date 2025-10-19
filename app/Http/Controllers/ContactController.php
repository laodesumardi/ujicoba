<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSection;
use App\Models\Message;
use App\Models\Notification;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        // Get contact section data
        $contactSection = HomeSection::where('section_key', 'contact')->first();
        
        // Get contact information
        $contact = \App\Models\Contact::getActive();
        
        return view('contact.index', compact('contactSection', 'contact'));
    }

    /**
     * Store a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create($request->all());

        // Create notification for admin
        Notification::createMessage($message->name, $message->id);

        return redirect()->route('contact.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
    }
}
