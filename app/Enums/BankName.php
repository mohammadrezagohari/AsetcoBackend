<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BANK_SADERAT()
 * @method static static ZARINPAL()
 * @method static static BANK_MELLAT()
 */
final class BankName extends Enum
{
    const BANK_SADERAT = 0;
    const ZARINPAL = 1;
    const BANK_MELLAT = 2;
    const ALL = [
        self::BANK_SADERAT,
        self::ZARINPAL,
        self::BANK_MELLAT,
    ];
}
