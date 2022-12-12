<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Enums\UserRoleEnum;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $company_id
 * @property string $job_title
 * @property string|null $district
 * @property string|null $city
 * @property int|null $remotable
 * @property int|null $is_part_time
 * @property float|null $min_salary
 * @property float|null $max_salary
 * @property int|null $currency_salary
 * @property string|null $requirement
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $number_applicants
 * @property int $status
 * @property int $is_pinned
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\File|null $file
 * @property-read string $currency_salary_code
 * @property-read mixed $location
 * @property-read mixed $remotable_name
 * @property-read string $salary
 * @property-read string $status_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Language[] $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post approved()
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCurrencySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMaxSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMinSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereNumberApplicants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRemotable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRequirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
 */
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

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date'   => 'datetime:Y-m-d',
    ];

    protected static function booted()
    {
        static::creating(static function ($object) {
            $object->user_id = auth()->id();
            $object->status  = PostStatusEnum::getStatusByRole();
        });

        static::saved(static function ($object) {
            $city    = $object->city;
            $arr     = explode(', ', $city);
            $arrCity = getAndCachePostCities();
            foreach ($arr as $each) {
                if (in_array($each, $arrCity, true)) {
                    continue;
                }
                if (is_null($each)) {
                    continue;
                }
                $arrCity[] = $each;
            }
            cache()->put(SystemCacheKeyEnum::POST_CITIES, $arrCity);
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('status', PostStatusEnum::ADMIN_APPROVED);
    }

    public function getIsClosedAttribute(): bool
    {
        if (empty($this->start_date) || empty($this->end_date)) {
            return false;
        }

        return !now()->between($this->start_date, $this->end_date);
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

    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }

    public function getCurrencySalaryCodeAttribute(): string
    {
        return PostCurrencySalaryEnum::getKey($this->currency_salary);
    }

    public function getStatusNameAttribute(): string
    {
        return PostStatusEnum::getKey($this->status);
    }

    public function getLocationAttribute()
    {
        if (!empty($this->district)) {
            return $this->district . ', ' . $this->city;
        }

        return $this->city;
    }

    public function getRemotableNameAttribute()
    {
        $key = PostRemotableEnum::getKey($this->remotable);
        $arr = explode('_', $key);
        $str = '';

        foreach ($arr as $each) {
            $str .= Str::title($each) . ' ';
        }

        return $str;
    }

    public function getSalaryAttribute(): string
    {
        $val    = $this->currency_salary;
        $key    = PostCurrencySalaryEnum::getKey($val);
        $locale = PostCurrencySalaryEnum::getLocaleByVal($val);
        $format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $rate   = Config::getRateByKey($key);

        if (!is_null($this->min_salary)) {
            $salary    = $this->min_salary * $rate;
            $minSalary = $format->formatCurrency($salary, $key);
        }
        if (!is_null($this->max_salary)) {
            $salary    = $this->max_salary * $rate;
            $maxSalary = $format->formatCurrency($salary, $key);
        }

        if (!empty($minSalary) && !empty($maxSalary)) {
            return $minSalary . ' - ' . $maxSalary;
        }

        if (!empty($minSalary)) {
            return __('frontpage.from_salary') . ' ' . $minSalary;
        }

        if (!empty($maxSalary)) {
            return __('frontpage.to_salary') . ' ' . $maxSalary;
        }

        return '';
    }
}
