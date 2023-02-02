<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ACCEPTED
 * @method static static WAIT
 * @method static static IN_WAY
 * @method static static ARRIVE
 * @method static static START_WORK
 * @method static static FINISH_WORK
 * @method static static ALL
 */
final class DeliveryStep extends Enum
{
    const WAIT = 'wait';
    const ACCEPTED = 'accepted';
    const IN_WAY = 'in_way';
    const ARRIVE = 'arrive';
    const START_WORK = 'start_work';
    const FINISH_WORK = 'finish_work';
    const PAID = 'paid';
    const ALL = [
        self::ACCEPTED,
        self::WAIT,
        self::IN_WAY,
        self::ARRIVE,
        self::START_WORK,
        self::FINISH_WORK,
        self::PAID
    ];
}
