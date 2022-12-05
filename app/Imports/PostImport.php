<?php

namespace App\Imports;

use App\Enums\FileTypeEnum;
use App\Enums\PostStatusEnum;
use App\Models\Company;
use App\Models\File;
use App\Models\Language;
use App\Models\Post;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class PostImport implements ToArray, WithHeadingRow
{
    public function array(array $array): void
    {
        try {
            foreach ($array as $each) {
                $companyName = $each['cong_ty'];
                $language    = $each['ngon_ngu'];
                $city        = $each['dia_diem'];
                $link        = $each['link'];

                if(!empty($companyName)){
                    $companyId = Company::firstOrCreate([
                        'name' => $companyName,
                    ], [
                        'country' => 'Vietnam',
                    ])->id;
                } else {
                    $companyId = null;
                }

                if(!empty($city)){
                    $city = Str::replace('HN', 'Hà Nội', $city);
                    $city = Str::replace('HCM', 'Hồ Chí Minh', $city);
                }

                $post = Post::create([
                    'job_title'  => $language,
                    'company_id' => $companyId,
                    'city'       => $city,
                    'status'     => PostStatusEnum::ADMIN_APPROVED,
                ]);

                $languages = explode(',', $language);
                foreach ($languages as $language) {
                    Language::firstOrCreate([
                        'name' => trim($language),
                    ]);
                }

                File::create([
                    'post_id' => $post->id,
                    'link'    => $link,
                    'type'    => FileTypeEnum::JD,
                ]);
            }
        } catch (Throwable $e) {

        }
    }
}
