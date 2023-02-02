<?php

namespace App\Enums;

class MechanicTypes
{
    public const MOBILE = 'mobile';
    public const STABLE = 'stable';
    public const BOTH = 'both';

    public const ALL = [
        self::MOBILE,
        self::STABLE,
        self::BOTH,
    ];
}
