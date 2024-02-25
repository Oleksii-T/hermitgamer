<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum PostTCStyle:int
{
    use EnumTrait;

    case R_SIDEBAR = 1;
    case WIDE = 2;

    public static function getReadable($val)
    {
        return match ($val) {
            self::R_SIDEBAR => 'Right Sidebar',
            self::WIDE => 'Wide',
        };
    }

}
