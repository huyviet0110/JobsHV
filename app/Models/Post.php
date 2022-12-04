<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'job_title',
        'city',
        'status',
        'company_id',
        "district",
        "remotable",
        "is_part_time",
        "min_salary",
        "max_salary",
        "currency_salary",
        "requirement",
        "start_date",
        "end_date",
        "number_applicants",
        "status",
        "is_pinned",
        "slug",
    ];

    public function getCurrencySalaryCodeAttribute()
    {
        return PostCurrencySalaryEnum::getKey($this->currency_salary);
    }

    public function getStatusNameAttribute()
    {
        return PostStatusEnum::getKey($this->status);
    }

    public function getLocationAttribute()
    {
        if (!empty($this->district)) {
            return $this->district . ' - ' . $this->city;
        }

        return $this->city;
    }

    protected static function booted()
    {
        static::creating(static function ($object) {
            $object->user_id = auth()->id();
            $object->status  = 1;
        });

        static::saved(static function ($object) {
            $city = $object->city;
            $arr = explode(', ', $city);
            $arrCity = getAndCachePostCities();
            foreach ($arr as $each) {
                 if(in_array($each, $arrCity, true)){
                     continue;
                 }
                 $arrCity[] = $each;
            }
            cache()->put(SystemCacheKeyEnum::POST_CITIES, $arrCity);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }

    public function languages()
    {
        return $this->morphToMany(
            Language::class,
            'object',
            ObjectLanguage::class,
            'object_id',
            'language_id',
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
