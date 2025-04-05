<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_name',
        'type',
        'min_duration_days',
        'max_duration_days',
        'duration_breakage_days',
        'processing_fee',
    ];
}
