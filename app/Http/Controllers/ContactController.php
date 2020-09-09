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
        // Find all selected gropus
        $groups = Group::find([1]);
        $contacts = [];
        foreach ($groups as $group) {
            // find contacts in each group
            $contacts[] = $group->contacts()->pluck('phone_number');
        }
        // merge the group contacts arrays
        $merged = collect($contacts)->collapse()->toArray();
        // remove the duplicate contacts: one contact can belong to more than one group
        $contacts = array_merge(array_unique($merged), array());
        return response()->json(['merged' => $merged, 'contacts' => $contacts]);
//        $rest = '+254' . substr("0728656735", 1);
//        $rest = substr("+254728656735", -9);
//        echo $rest;
//        $messageService = new MessageService;
//        $messageService->sendSMS(["0728656735", "0706318147"], "We are testing the messages!\n^Joe Gitonga");
//        $contacts = Auth::user()->contacts;
//        return ContactResource::collection($contacts);
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
