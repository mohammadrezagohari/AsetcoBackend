<?php

namespace App\Enums;

class RegularExpressionLocation
{
    public const LATITUDE = "/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/";
    public const LONGITUDE = "/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/";
}
