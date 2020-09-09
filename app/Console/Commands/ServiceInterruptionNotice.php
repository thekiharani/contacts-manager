<?php

namespace App\Console\Commands;

use App\Group;
use App\Services\MessageService;
use Illuminate\Console\Command;

class ServiceInterruptionNotice extends Command
{
    protected $messageService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:serviceinterruption';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies the employees about internet service interruption every day between 1-1:30 pm';

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
        $contacts = Group::where('name', 'Employees')->first()->contacts()->pluck('phone_number')->toArray();
        $message = "Please be aware of our daily internet interruption between 1-1:30 pm\n^NoriaHub";
        $this->messageService->sendSMS($contacts, $message);
        echo "Notification sent to members\n";
    }
}
