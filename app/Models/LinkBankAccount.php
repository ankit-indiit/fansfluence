<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_acc_registerd_in',
        'bic_swift_code',
        'routing_number',
        'account_number',
        'account_name',
    ];
}
