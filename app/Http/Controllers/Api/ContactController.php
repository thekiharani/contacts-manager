<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Helpers\StringHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $contacts = $request->user()->contacts()->orderBy('updated_at', 'DESC')->get();
        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContactRequest $request)
    {
        // Validation done via ContactRequest
        $validated_data = $request->validated();
        // Format the phone number with Kenyan Code
        $validated_data['phone_number'] = StringHelpers::ke_phone_number($validated_data['phone_number']);
        $contact = new Contact($validated_data);
        Auth::user()->contacts()->save($contact);
        return response()->json(['message' => 'Contact Created', 'contact' => new ContactResource($contact)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contact $contact
     * @return ContactResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contact $contact
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        // Validation done via ContactRequest
        $validated_data = $request->validated();
        $validated_data['phone_number'] = StringHelpers::ke_phone_number($validated_data['phone_number']);
        $contact->update($validated_data);
        return response()->json(['message' => 'Contact Updated', 'contact' => new ContactResource($contact)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        $contact->delete();
        return response()->json(['message' => 'Contact Deleted'], 204);
    }
}
