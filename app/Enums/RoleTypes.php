<?php

namespace App\Enums;

class RoleTypes
{
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const MECHANIC = 'mechanic';
    public const MOBILE_MECHANIC = 'mobile_mechanic';
    public const STABLE_MECHANIC = 'stable_mechanic';
    public const USER = 'user';

    public const ALL = [
        self::SUPER_ADMIN,
        self::ADMIN,
        self::MECHANIC,
        self::MOBILE_MECHANIC,
        self::STABLE_MECHANIC,
        self::USER
    ];
}
