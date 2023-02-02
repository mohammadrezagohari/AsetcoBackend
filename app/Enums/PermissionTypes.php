<?php

namespace App\Enums;

class PermissionTypes
{
    public const EDIT_ROLE = 'edit admin';
    public const ASSIGN_ROLE = 'assign role';
    public const EDIT_USER = 'edit user';
    public const EDIT_SERVICE = 'edit service';
    public const EDIT_CAR = 'edit car';
    public const EDIT_MECHANIC = 'edit mechanic';
    public const EDIT_PRODUCT = 'edit product';

    public const ALL = [
        self::EDIT_ROLE,
        self::ASSIGN_ROLE,
        self::EDIT_USER,
        self::EDIT_MECHANIC,
        self::EDIT_SERVICE,
        self::EDIT_CAR,
        self::EDIT_PRODUCT
    ];

}
