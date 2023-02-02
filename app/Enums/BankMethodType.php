<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static GET_METHOD()
 * @method static static POST_METHOD()
 */
final class BankMethodType extends Enum
{
    public const GET_METHOD = 0;
    public const POST_METHOD = 1;
}
