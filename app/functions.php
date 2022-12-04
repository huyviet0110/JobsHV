<?php

use App\Enums\SystemCacheKeyEnum;
use App\Enums\UserRoleEnum;
use App\Models\Post;

if(!function_exists('getRoleByKey')){
    function getRoleByKey($key): string
    {
        return strtolower(UserRoleEnum::getKey($key));
    }
}

if(!function_exists('getAndCachePostCities')){
    function getAndCachePostCities(): array
    {
        return cache()->remember(SystemCacheKeyEnum::POST_CITIES, (24 * 60 * 60) * 30, function () {
            $cities  = Post::query()
                ->pluck('city')
                ->toArray();
            $arrCity = [];
            foreach ($cities as $city) {
                if (empty($city)) {
                    continue;
                }
                $arr = explode(', ', $city);
                foreach ($arr as $each) {
                    if (in_array($each, $arrCity, true)) {
                        continue;
                    }
                    $arrCity[] = $each;
                }
            }

            return $arrCity;
        });
    }
}
