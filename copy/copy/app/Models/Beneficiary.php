<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $table = 'beneficiaries'; // Define table name

    protected $primaryKey = 'id'; // Primary key

    public $incrementing = true; // Auto-increment

    //protected $keyType = 'bigint'; // Type of primary key

    protected $fillable = [
        'easypaisa_customer_id',
        'first_name',
        'last_name',
        'nominee_name',
        'gender',
        'nominee_relationship',
        'beneficiary_type',
        'nationality',
        'address',
        'date_of_birth',
        'beneficiary_percentage',
        'contact_number',
        'cnic',
        'cnic_expiry_date',
        'policy_number',
        'bank_name',
        'title_of_account',
        'account_number',
        'iban',
        'insurance_id',
    ];

    protected $dates = ['date_of_birth', 'cnic_expiry_date', 'created_at', 'updated_at'];

    /**
     * Relationship with Easypaisa Customer
     */
    public function easypaisaCustomer()
    {
        return $this->belongsTo(EasypaisaUser::class, 'easypaisa_customer_id');
    }

    /**
     * Relationship with Insurance Data
     */
    public function insurance()
    {
        return $this->belongsTo(InsuranceData::class, 'insurance_id');
    }
}
