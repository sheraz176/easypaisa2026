<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investmentmaster extends Model
{
    use HasFactory;


    public function customer()
    {
        return $this->belongsTo(CustomerInformation::class, 'customer_id'); // Ensure the foreign key matches your column name
    }
}
