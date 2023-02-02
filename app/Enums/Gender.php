<?php

namespace App\Enums;

class Gender 
{
    public const MALE = 'male';
    public const FEMALE = 'female';
    public const UNKNOWN = 'unknown';

    public const ALL = [
        self::MALE,
        self::FEMALE,
        self::UNKNOWN
    ];
}