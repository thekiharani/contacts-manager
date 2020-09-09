<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\Http\Controllers\Controller;
use App\Services\MessageService;
use Illuminate\Http\Request;

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
        $this->messageService->sendSMS($contacts, $message);
        return response()->json(['message' => 'messages sent successfully'], 200);
    }

    // send sms to group members
    public function sendGroupText(Request $request)
    {
        $contacts = Group::find($request->group)->contacts()->pluck('phone_number');
        $message = $request->message;
        $this->messageService->sendSMS($contacts, $message);
        return response()->json(['message' => 'messages sent successfully'], 200);
    }


}
