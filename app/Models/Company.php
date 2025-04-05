<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'registration_number',
        'ntn',
        'secp_registration',
        'business_type',
        'authorized_capital',
        'registration_date',
        'is_active',
        'status',
        'package_assigned',

    ];


}
