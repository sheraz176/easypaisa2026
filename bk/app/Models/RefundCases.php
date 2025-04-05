<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundCases extends Model
{
    use HasFactory;


    protected $fillable = [
        'investment_master_id',
        'refund_amount',
        'refund_request_date',
        'refund_processed_date',
        'processing_fee_deducted',
        'status',
        'type',
    ];

    // If you have an InvestmentMaster model, you can define a relationship here
    public function investmentMaster()
    {
        return $this->belongsTo(InvestmentMaster::class);
    }

    public function customer()
    {
        return $this->belongsTo(CustomerInformation::class, 'customer_id'); // Ensure the foreign key matches your column name
    }

}
