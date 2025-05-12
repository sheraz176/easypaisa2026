<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = ['msisdn', 'refund_amount','customer_id','status','file','status_updated_at'];

    public function customer()
    {
        return $this->belongsTo(EasypaisaUser::class, 'customer_id');
    }

    /**
     * Relationship with Customer Savings Master
     */
    public function savings()
    {
        return $this->belongsTo(CustomerSavingsMaster::class, 'customer_id');
    }

}
