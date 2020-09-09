<?php


namespace App\Services;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;


class MessageService
{
    private $username;
    private $apiKey;

    public function __construct()
    {
        $this->username = env('AT_API_USERNAME', 'sandbox');
        $this->apiKey = env('AT_API_KEY', '');
    }

    public function sendSMS($contacts, $message)
    {
        try {
            $AT       = new AfricasTalking($this->username, $this->apiKey);
            // Get one of the services
            $sms      = $AT->sms();
            // Use the service
            $result   = $sms->send([
                'to'      => $contacts,
                'message' => $message
            ]);

            Log::info((string)json_encode(['AT SMS' => $result]));
            return $result;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
