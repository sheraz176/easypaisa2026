<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlySummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'customer_id',
        'amount_earned',
        'cumulative_amount',
        'fund_growth_amount',
        'efu_share',
        'easypaisa_share',
        'customer_share',
        'sum_assured',
        'sum_at_risk',
        'mortality_charges',
        'ptf_share',
        'osf_share',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(EasypaisaUser::class, 'customer_id');
    }
}
