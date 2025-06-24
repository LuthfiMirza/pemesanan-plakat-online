<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'sender_name',
        'bank_name',
        'amount',
        'custom_design',
        'design_notes',
        'proof_of_payment',
        'payment_method',
        'status'
    ];
}