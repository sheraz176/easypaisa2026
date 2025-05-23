<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    use HasFactory;


    public function investmentMasters()
    {
        return $this->hasMany(InvestmentMaster::class);
    }
}
