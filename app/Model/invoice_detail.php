<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    //
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
