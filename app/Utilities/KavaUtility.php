<?php

namespace App\Utilities;

class KavaUtility
{
    public static function getEnpoint (string $brokerName)
    {
        $data_format = config()->get('kava');
        $broker_name = strtolower(trim($brokerName));
        return $data_format[$broker_name];
    }
}