<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = [

        'tran_ref',
        'reference_no',
        'transaction_id',
        'user_id',
        'status',
        'cart_amount',
        'tran_currency'

    ];
}
