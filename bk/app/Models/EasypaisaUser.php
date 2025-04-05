<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasypaisaUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'open_id',
        'union_id',
        'user_msisdn',
        'result_code',
        'result_status',
        'result_message',
        'other'
    ];
}
