<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceData extends Model
{
    use HasFactory;

    protected $table = 'insurance_data';

    protected $primaryKey = 'id';

    public $incrementing = true;

   // protected $keyType = 'bigint';

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'saving_id',
        'beneficiary_id',
        'policy_start_date',
        'policy_end_date',
        'eful_policy_number',
        'eful_status',
        'eful_data1',
        'active_eful_policy_number',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'policy_start_date' => 'date',
        'policy_end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with Customer Information
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

    /**
     * Relationship with Beneficiaries (optional)
     */
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }
}
