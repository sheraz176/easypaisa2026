<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentLedgerSaving extends Model
{
    use HasFactory;

    protected $table = 'investment_ledger_saving';

    protected $primaryKey = 'id';

    public $incrementing = true;

    //protected $keyType = 'bigint';

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'saving_id',
        'transaction_id',
        'amount',
        'transaction_type',
        'date_time',
        'net_amount',
        'gross_amount',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'gross_amount' => 'decimal:2',
        'date_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with Easypaisa Users
     */
    public function customer()
    {
        return $this->belongsTo(EasypaisaUser::class, 'customer_id');
    }

    /**
     * Relationship with Customer Savings Master
     */
    public function savings()
    {
        return $this->belongsTo(CustomerSavingsMaster::class, 'saving_id');
    }
}
