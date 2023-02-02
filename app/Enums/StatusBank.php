<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusBank extends Enum
{
    const SUCCESS = 0;   //// موفق
    const NOTFOUND = -1; //// تراکنش پیدا نشد.

    const CONFLICT = -2;
    //// -در زمان دریافت توکن به دلیل عدم وجود )عدم تطابق( IP و یا به دلیل بسته بودن خروجی پورت 8081 از
    ////سمت Host این خطا ایجاد میگردد.
    ////تراکنش قبال Reverse شده است.
    const EXCEPTION = -3;
    /// Error Total خطای عمومی – خطای Exception ها
    const CAN_NOT_DO = -4;
    //// امکان انجام درخواست برای این تراکنش وجود ندارد
    const IP_INVALID = -5;
    ///// آدرس IP نامعتبر میباشد )IP در لیست آدرسهای معرفی شده توسط پذیرنده موجود نمیباشد
    const FAIL_SERVICE = -6;
    //////عدم فعال بودن سرویس برگشت تراکنش برای پذیرنده
    const ALL=[
        self::SUCCESS,
        self::NOTFOUND,
        self::CONFLICT,
        self::EXCEPTION,
        self::CAN_NOT_DO,
        self::FAIL_SERVICE,
    ];

}
