<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PAYED
 * @method static static PENDING
 * @method static static CANCEL
 * @method static static ALL
 */
final class PaymentStatus extends Enum
{
    const PAYED = 'payed';
    const PENDING = 'pending';
    const CANCEL = 'cancel';
    const ALL = [
        self::PAYED,
        self::PENDING,
        self::CANCEL,
    ];

}
