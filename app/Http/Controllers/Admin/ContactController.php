<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact information management page
     */
    public function index()
    {
        $contact = Contact::getActive();
        return view('admin.contact.index', compact('contact'));
    }

    /**
     * Update contact information
     */
    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'required|string|max:255',
        ]);

        $contact = Contact::getActive();
        
        if ($contact) {
            $contact->update($request->only(['address', 'phone', 'email', 'website']));
        } else {
            Contact::create([
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil diperbarui!');
    }
}
