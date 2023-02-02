<?php

namespace App\Enums;

class MediaTypes 
{
    public const AVATAR = 'avatar';
    public const COVER_VIDEO = 'cover_video';

    public const ALL = [
        self::AVATAR,
        self::COVER_VIDEO,
    ];
}