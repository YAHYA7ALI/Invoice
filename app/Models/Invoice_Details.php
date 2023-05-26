<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_Details extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'product',
        'Section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'Payment_Date',
    ];
}
