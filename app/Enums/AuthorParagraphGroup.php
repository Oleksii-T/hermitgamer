<?php

namespace App\Enums;

use \App\Traits\EnumTrait;

enum AuthorParagraphGroup:int
{
    use EnumTrait;

    case MAIN = 0;
    case AFTER_MISSION = 1;

    public static function getReadable($val)
    {
        return match ($val) {
            self::MAIN => 'Main',
            self::AFTER_MISSION => 'After Mission Block',
        };
    }

}
