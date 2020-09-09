<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Group;
use App\Http\Resources\ContactResource;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // $contacts = Group::where('name', 'Employees')->first()->contacts()->pluck('phone_number');
        $contacts = Contact::whereIn('phone_number', ['+254711223344', '+254722334455'])->pluck('phone_number')->toArray();
        return $contacts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
    }
}
