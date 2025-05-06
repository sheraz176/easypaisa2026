<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarManagement extends Model
{
    use HasFactory;

    protected $table = 'calender_management'; // Define table name

    protected $primaryKey = 'id'; // Primary key

    public $incrementing = true; // Auto-increment enabled

    protected $keyType = 'bigint'; // Type of primary key

    protected $fillable = [
        'holiday_date',
        'description',
        'holiday_type',
        'is_national_holiday',
        'is_repeated',
        'effective_from',
        'effective_to',
        'status',
    ];

    protected $dates = ['holiday_date', 'effective_from', 'effective_to', 'created_at', 'updated_at'];

    /**
     * Scope for Active Holidays
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for National Holidays
     */
    public function scopeNationalHolidays($query)
    {
        return $query->where('is_national_holiday', 1);
    }

    /**
     * Scope for Holidays within a Date Range
     */
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('holiday_date', [$start, $end]);
    }
}
