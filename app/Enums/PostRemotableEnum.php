<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class PostRemotableEnum extends Enum
{
    public const REMOTE_ONLY = 1;
    public const OFFICE_ONLY = 2;
    public const HYBRID      = 3;

    public static function getArrLowerKey(): array
    {
        $data = self::asArray();
        $arr  = ['all' => 0];
        foreach ($data as $key => $val) {
            $index       = Str::lower($key);
            $arr[$index] = $val;
        }

        return $arr;
    }
}
