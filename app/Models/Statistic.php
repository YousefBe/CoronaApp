<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_update',
        'new_deaths',
        'total_deaths',
        'new_confirmed',
        'total_confirmed',
        'new_recovered',
        'total_recovered'
    ];
}
