<?php

namespace App\Enums;
/**
 * @method static static MOBILE
 * @method static static STABLE
 * @method static static BOTH
 */
class LocationType
{
    public const MOBILE = 'mobile';
    public const STABLE = 'stable';
    public const BOTH = 'both';

    public const ALL = [
        self::BOTH,
        self::MOBILE,
        self::STABLE
    ];
}
