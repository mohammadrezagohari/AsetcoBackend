<?php

namespace App\Enums;

class BasketStatusOrder
{

    public const SUCCESS = 'success';
    public const ACTIVE = 'active';
    public const SUSPENDED = 'suspended';
    public const CONTACT = 'contact';
    public const FAILS = 'fails';
    public const CANCEL = 'cancel';
    public const ALL = [
        self::FAILS,
        self::ACTIVE,
        self::SUSPENDED,
        self::SUCCESS,
        self::CONTACT,
        self::CANCEL
    ];

    public const WORK = [
        self::ACTIVE,
        self::SUSPENDED,
    ];

}
