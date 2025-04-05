<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CustomerSavingsMaster;
use App\Models\InvestmentLedgerSaving;


class EasypaisaUser extends Model
{
    use HasFactory;

    protected $table = 'easypaisa_users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    //protected $keyType = 'bigint';
    public $timestamps = true;

    protected $fillable = [
        'user_msisdn',
        'last_name',
        'first_name',
        'open_id',
        'union_id',
        'result_code',
        'result_status',
        'result_message',
        'other',
        'date_of_birth',
        'gender',
        'cnic',
        'mother_name',
        'father_name',
        'email_address',
        'address',
        'province',
        'city',
        'occupation',
        'beneficiary', // New field
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'beneficiary'   => 'boolean', // Ensure it's cast as a boolean
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function customerSaving(): HasOne
    {
        return $this->hasOne(CustomerSavingsMaster::class, 'customer_id');
    }

    public function dailyReturns(): HasMany
    {
        return $this->hasMany(DailyReturn::class, 'customer_id');
    }

    public function monthlySummaries(): HasMany
    {
        return $this->hasMany(MonthlySummary::class, 'customer_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(InvestmentLedgerSaving::class, 'customer_id');
    }

    public function savingStatus(): HasOne
    {
        return $this->hasOne(SavingStatus::class, 'customer_id');
    }
}
