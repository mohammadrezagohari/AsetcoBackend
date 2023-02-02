<?php

namespace App\Enums;

class VehicleTypes
{
    public const NONE = '-';
    public const CAR = 'car';
    public const MOTORCYCLE = 'motorcycle';

    public const ALL = [
        self::NONE,
        self::CAR,
        self::MOTORCYCLE,
    ];
}
