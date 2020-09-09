<?php


namespace App\Helpers;


class StringHelpers
{
    public static function ke_phone_number($phone_number)
    {
        return "+254" . substr($phone_number, -9);
    }
}
