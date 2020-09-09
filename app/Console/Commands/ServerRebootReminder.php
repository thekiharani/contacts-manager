<?php

namespace App\Console\Commands;

use App\Contact;
use App\Services\MessageService;
use Illuminate\Console\Command;

class ServerRebootReminder extends Command
{
    protected $messageService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:rebootserver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminds the system admin to reboot the server every 12 am';

    /**
     * Create a new command instance.
     *
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        parent::__construct();
        $this->messageService = $messageService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contacts = Contact::whereIn('phone_number', ['+254711223344', '+254722334455'])->pluck('phone_number')->toArray();
        $message = "Please reboot the server at 12 am\n^NoriaHub";
        $this->messageService->sendSMS($contacts, $message);
        echo "Reminder sent to admins\n";
    }
}
