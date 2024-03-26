<?php

namespace App\Traits;

trait GetAllSlugs
{
    public static function getAllSlugs($forget=false, $formatted=true)
    {
        $cKey = get_class() . '-slugs';

        dlog("$cKey"); //! LOG

        if ($forget) {
            cache()->forget($cKey);
        }

        $slugs = cache()->remember($cKey, 60*60*24, function () {
            return self::pluck('slug')->toArray();
        });

        dlog(" slugs", $slugs); //! LOG

        if ($formatted) {
            $slugs = '('.implode('|', $slugs).')';
        }

        dlog(" res $slugs"); //! LOG

        return $slugs;
    }
}

