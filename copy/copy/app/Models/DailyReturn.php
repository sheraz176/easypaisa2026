<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReturn extends Model
{
    use HasFactory;

    protected $table = 'daily_returns'; // Define table name

    protected $primaryKey = 'id'; // Primary key

    public $incrementing = true;

    //protected $keyType = 'bigint';

    protected $fillable = [
        'date',
        'customer_id',
        'saving_id',
        'investment_ledger_saving_id',
        'amount_earned',
        'commulative_amount',
        'fund_growth_amount',
        'efu_share',
        'easypaisa_share',
        'customer_share',
        'sum_assured',
        'sum_at_risk',
        'mortality_charges',
        'ptf_share',
        'osf_share',
        'type',
        'todays_interest_rate',
        'easypaisa_share_percentage',
        'efu_share_percentage',
        'customer_share_percentage',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship with Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(EasypaisaUser::class, 'customer_id');
    }

    /**
     * Relationship with Customer Savings Master
     */
    public function savings(): BelongsTo
    {
        return $this->belongsTo(CustomerSavingsMaster::class, 'saving_id');
    }

    /**
     * Relationship with Investment Ledger Saving
     */
    public function investmentLedgerSaving(): BelongsTo
    {
        return $this->belongsTo(InvestmentLedgerSaving::class, 'investment_ledger_saving_id');
    }
}
