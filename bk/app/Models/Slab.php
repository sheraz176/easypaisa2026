<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slab extends Model
{
    use HasFactory;


    protected $fillable = [
        'package_id',
        'slab_name',
        'initial_deposit',
        'maximum_deposit',
        'daily_return_rate',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function customerSavings(): HasMany
    {
        return $this->hasMany(CustomerSavingsMaster::class, 'activated_slab', 'id');
    }

}
