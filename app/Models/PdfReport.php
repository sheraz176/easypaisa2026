<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'msisdn',
        'amount',
        'contribution_term',
        'sum_covered',
        'profit_at_9',
        'profit_at_13',
        'pdf_path',
    ];
}
