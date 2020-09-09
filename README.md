# Contacts Manager
## Introduction
Contacts manager is a simple web application built with [Laravel](https://laravel.com) and [VueJS](https://cli.vuejs.org). It allows users to create contacts and groups for easier communication using bulk SMS [(Africas Talking SMS API)](https://africastalking.com/sms).

Basically, the main components are:
- Basic Authentication
- Contacts
- Groups
- SMS

## Working
- User Registration - User create and manage their account using the [Basic Laravel Authentication](https://laravel.com/docs/8.x/authentication) (only a phone number is added).
- Contacts and Group Creation - Once registered and authenticated, a user can create unlimited (ideally) contacts and groups. Both contacts and groups have a [1:M relationship](https://laravel.com/docs/8.x/eloquent-relationships#one-to-one) with the user. Hence, a user can only manage the contacts and groups they own. Contacts and groups have [M:N relationship](https://laravel.com/docs/8.x/eloquent-relationships#many-to-many), so a user can belong to multiple groups, and a group can have many users.

### Contacts and Groups
Both contacts and groups have three options implemented:
- Send SMS - Send to one or more contacts, OR all contacts in one or more groups (Removes duplicate in case a contact belong to multiple groups receiving the same message at a time. Such contact will hence receive a single message).
- Attach - add contacts to groups in either direction (M:N relationship)
- Delete - Delete single or multiple contacts or groups.

### SMS
SMSs can be sent instantly or scheduled. Instant SMS option is fully covered in this application. For scheduled SMSs, a complete prototype is given with justification.

The Scheduling is achieved through a custom command for [Laravel Scheduler](https://laravel.com/docs/8.x/scheduling#introduction). The Scheduling achieves the following: 
1. Send SMS to two hypothetical system admins every day at 11:45 PM, reminding them to reboot the server at 12:00 AM (console command: `php artisan reminder:rebootserver`). In order to replicate this, you must have two contacts with the phone numbers `+254711223344` and `+254722334455` respectively. The phone numbers are used to query the database. 
2. Send SMS to the hypothetical `Employees` group members every day at 12:45 PM, notifying them of the network interruption between 1-1:30 PM (console command: `php artisan notice:serviceinterruption`). In order to replicate this, you must have a group by the name `Employees`, and with some members. The group name is used to query the database.
__For testing with a different time scheduling, you can edit this in: `app\Console\Kernel.php lines 28 and 33`__

The scheduled sms are meant to run automatically on a live server using cron jobs. However, for local development, the schedule has to be triggered manually by the command: `php artisan schedule:run`. Maybe a containerized setup can be made to mimic live server and duplicated across devs ([Docker](https://dev.to/lostdesign/how-to-run-laravel-in-docker-4e6o) or [Homestead](https://laravel.com/docs/8.x/homestead)).

### SMS delivery report
I did not find a proper documentation on how to get the delivery reports from the AT APIs. The closes I got was [this callback URL](https://account.africastalking.com/apps/sandbox/sms/dlr/callback) which sends back delivery report per SMS. The solution will be to save these delivery reports to DB (ONLY if necessary). This callback work only in publicly available addresses (not localhost, [ngrok](https://ngrok.com/) can be a testing solution). The callback URL is: __`https://<ngrok-base-url>/api/sms_callback`__ A sample response I received via my log file using ngrok tunnelling looks as follows:

``
[2020-09-09 19:39:07] local.INFO: phoneNumber=%2B254706318147&failureReason=DeliveryFailure&retryCount=0&id=ATXid_8c7541e938f63538f971f946dd25b54e&status=Failed&networkCode=63902 
``

Basically, this contains all the necessary parameters which can be extracted and stored for reference.

## Getting up and running with this project
- Clone the repo: `git clone git@github.com:thekiharani/contacts-manager.git` (using SSH) OR `git clone https://github.com/thekiharani/contacts-manager.git` (using HTTPS)
- Change to the project directory: `cd contacts-manager [or any name given to the project during clone]`
- Copy the `.env.example` file into `.env` file: `cp .env.example .env`
- Configure APP_NAME, URL, database, (mailtrap, if necessary), AT KEY and USERNAME at the very bottom, and any other necessary configuration.
- Install the required packages: `composer install` OR `composer update`
- Spin the dev server: `php artisan serve`

__Please ensure that you have two contacts with the phone number given in point 1. under SMS above, as well as a group with name Employees. Alternatively, you can modify the schedule with your matching data in: `app\Console\Commands\ServerRebootReminder.php` and `app\Console\Commands\ServiceInterruptionNotice.php` classes__

## What can be improved for production
- Write the Tests for the app functionality
- Refactor the front-end Vue components
- Add contact and group editing functionality to the UI (it exists in the backed-end API)
- Provide an interface for the users to schedule more dynamic messages.
- Use queues and jobs dispatching in SMS sending.
