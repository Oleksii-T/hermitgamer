<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum PostStatus:int
{
    use EnumTrait;

    case DRAFT = 1;
    case PUBLISHED = 2;

    public static function getReadable($val)
    {
        return match ($val) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
        };
    }

}
