<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactDeletedMail;
use App\Http\Requests\ContactsRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(10);

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    public function store(ContactsRequest $request)
    {

        $data = $request->validated();
        $data['phone'] = preg_replace('/\D/', '', $data['phone']);

        $contact = Contact::create($data);

        return response()->json([
            'message' => 'Contact created successfully.',
            'contact' => $contact,
        ], 200);
    }

    public function update(ContactsRequest $request, Contact $contact)
    {
        $data = $request->validated();
        $data['phone'] = preg_replace('/\D/', '', $data['phone']);

        $contact->update($data);

        return response()->json(['message' => 'Contact updated successfully'], 200);
    }

    public function destroy(Contact $contact)
    {
        // Verifica se o contato tem e-mail válido antes de enviar
        if (filter_var($contact->email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($contact->email)->send(new ContactDeletedMail($contact));
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully and email sent'], 200);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $contacts = Contact::where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate(10); // você pode ajustar esse valor

        return response()->json($contacts);
    }
}
