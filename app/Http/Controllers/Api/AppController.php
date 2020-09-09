<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    // send personal sms to one or multiple users
    public function sendPersonalText(Request $request)
    {
        $contacts = $request->contacts;
        $message = $request->message;
        $res = $this->messageService->sendSMS($contacts, $message);
        return response()->json(['message' => $res], 200);
    }

    // send sms to group members
    public function sendGroupText(Request $request)
    {
        $groups = Group::find($request->groups);
        $contacts = [];
        foreach ($groups as $group) {
            // find contacts in each group
            $contacts[] = $group->contacts()->pluck('phone_number');
        }
        // merge the group contacts arrays
        $merged = collect($contacts)->collapse()->toArray();
        // remove the duplicate contacts: one contact can belong to more than one group
        $contacts = array_merge(array_unique($merged), array());
        $message = $request->message;
        $res = $this->messageService->sendSMS($contacts, $message);
        return response()->json(['message' => $res], 200);
    }

    // Add users to the group
    public function attachGroupContacts(Request $request)
    {
        $group = Group::find($request->group);
        $contact_ids = $request->contacts;
        $group->contacts()->detach($contact_ids);
        $group->contacts()->attach($contact_ids);
        return response()->json(['message' => 'Selected contacts added to the group'], 201);
    }

    // Add users to multiple groups
    public function attachContactsGroups(Request $request)
    {
        $groups = Group::find($request->groups);
        $contact_ids = $request->contacts;
        foreach ($groups as $group) {
            $group->contacts()->detach($contact_ids);
            $group->contacts()->attach($contact_ids);
        }
        return response()->json(['message' => 'Selected contacts added to the respective groups'], 201);
    }

    // Delete multiple contacts
    public function deleteContacts(Request $request)
    {
        $contact_ids = $request->contacts;
        Contact::whereIn('id', $contact_ids)->delete();
        return response()->json(['message' => 'Contacts deleted'], 200);
    }

    // Delete multiple groups
    public function deleteGroups(Request $request)
    {
        $group_ids = $request->groups;
        Group::whereIn('id', $group_ids)->delete();
        return response()->json(['message' => 'Groups deleted'], 200);
    }

    public function smsCallback(Request $request)
    {
        $payload =  file_get_contents('php://input');
        Log::info($payload);
        return $payload;
    }
}
