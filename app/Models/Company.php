<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "address",
        "address2",
        "city",
        "country",
        "district",
        "email",
        "id",
        "logo",
        "name",
        "phone",
        "zipcode",
    ];

    public $timestamps = false;
}
