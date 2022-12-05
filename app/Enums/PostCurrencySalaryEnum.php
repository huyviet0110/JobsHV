<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PostCurrencySalaryEnum extends Enum
{
    public const VND = 1;
    public const USD = 2;
    public const EUR = 3;
    public const JPY = 4;
    public const KRW = 5;
    public const CNY = 6;

    public static function getLocaleByVal($val): string
    {
        $locale = [
            self::VND => 'vi_VN',
            self::USD => 'en_US',
            self::EUR => 'en_UK',
            self::JPY => 'ja_JP',
            self::KRW => 'ko_KR',
            self::CNY => 'ch_CN',
        ];

        return $locale[$val];
    }
}
