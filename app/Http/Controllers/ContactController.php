<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
{
    $contacts = Contact::latest()->paginate(5); 
    return view('admin.admincustomers', compact('contacts'));
}

public function destroy($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();

    return back()->with('success', 'Contact deleted successfully.');
}


     public function submit(Request $request)
    {
        // Validate the form inputs
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'mobile'  => 'required|string|max:20',
            'address' => 'required|string',
            'message' => 'required|string',
        ]);

        // Save to database
        Contact::create($validated);

        // Redirect with success message
        return redirect()->back()->with('success', 'Thank you! We will contact you soon.');
    }
}
