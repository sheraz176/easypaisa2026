<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSavingsMaster extends Model
{
    use HasFactory;

    protected $table = 'customer_savings_master'; // Define table name

    protected $primaryKey = 'id'; // Primary key

    public $incrementing = true; // Auto-increment enabled

    //protected $keyType = 'bigint'; // Type of primary key

    protected $fillable = [
        'customer_id',
        'customer_msisdn',
        'customer_union_id',
        'initial_deposit',
        'plan',
        'activated_slab',
        'fund_growth_amount',
        'saving_status',
        'saving_start_date',
        'saving_end_date',
        'tenure_days',
        'active_days',
        'maturity_status',
        'last_profit_calculated_at',
    ];

    protected $dates = [
        'saving_start_date',
        'saving_end_date',
        'last_profit_calculated_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship with Customer (assuming `easypaisa_users` is the customer table)
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(EasypaisaUser::class, 'customer_id');
    }

    /**
     * Scope for Active Savings
     */
    public function scopeActiveSavings($query)
    {
        return $query->where('saving_status', 'on-going');
    }

    /**
     * Scope for Completed Savings
     */
    public function scopeCompletedSavings($query)
    {
        return $query->where('saving_status', 'tenure_complete');
    }

    /**
     * Scope for Savings in Progress
     */
    public function scopeInProgress($query)
    {
        return $query->where('maturity_status', 'in-progress');
    }

    /**
     * Scope for Savings Maturing within a Date Range
     */
    public function scopeMaturingBetween($query, $start, $end)
    {
        return $query->whereBetween('saving_end_date', [$start, $end]);
    }

    public function slab(): BelongsTo
{
    return $this->belongsTo(Slabs::class, 'activated_slab', 'id');
}
}
