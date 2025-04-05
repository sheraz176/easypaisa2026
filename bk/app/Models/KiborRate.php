<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiborRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'effective_date',
        'kibor_rate',
        'status',
    ];
}
