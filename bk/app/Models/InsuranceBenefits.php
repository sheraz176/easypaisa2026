<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceBenefits extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'benefit_type', 'benefit_name', 'benefit_description', 'amount'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }


}
