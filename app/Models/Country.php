<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'country_id',
        'new_recovered',
        'total_recovered',
        'new_deaths',
        'total_deaths',
        'new_confirmed',
        'total_confirmed'
    ];
}
