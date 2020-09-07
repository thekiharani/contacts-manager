<?php


namespace App\Repositories;


use App\Contact;
use Illuminate\Support\Facades\Auth;

class ContactRepository
{
    // Get contacts for authenticated user
    public function myContacts()
    {
        return Auth::user()->contacts;
    }

    // Create a new contact
    public function createContact($data)
    {
        $contact = new Contact;
        $contact->name = $data["name"];
        $contact->phone_number = $data["phone_number"];
        $contact->user_id = Auth::id();
        $contact->save();
        return $contact;
    }

    // Update existing contact
    public function updateContact($contact_id, $data)
    {
        $contact = Contact::find($contact_id);
        $contact->name = $data["name"];
        $contact->phone_number = $data["phone_number"];
        $contact->save();
        return $contact;
    }

    // Delete contact
    public function deleteContact($contact_id)
    {
        Contact::find($contact_id)->delete();
        return response(['message' => 'Contact Deleted!'], 200);
    }

}
