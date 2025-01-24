<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletHistory extends Model
{
    use HasFactory;
    // credit and debit
    CONST Wallet_TRANSATION = ['credited' => 1,'debited' => 2, 'debit_request' => 3];
    CONST Wallet_STATUS = ['pending' => 1,'approve' => 2, 'rejected' => 3];
}
