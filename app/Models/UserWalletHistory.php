<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UserWalletHistory extends Model
{
    use HasFactory;
    // credit and debit
    CONST Wallet_TRANSATION = ['credited' => 1,'debited' => 2, 'debit_request' => 3,'purchase_amount' => 4];
    CONST Wallet_STATUS = ['pending' => 1,'approve' => 2, 'rejected' => 3];

    public function userDetails(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public static function walletAmountDetails($id){
        $walletData = DB::table('user_wallet_histories as uwh')
        ->select(
            'uwh.id as transaction_id',
            'uwh.amount as purchase_amount',
            'uwh.status as status',
            'uwh.created_at as created_at',
            'uwh2.id as tran_id',
            'uwh2.amount as transfer_amount',
            'uwh2.status as transfer_status',
            'uwh2.created_at as transfer_created_at',
            'user1.name as purchase_user',
            'user2.name as transfer_user'
        )
        ->join('user_wallet_histories as uwh2', 'uwh.id', '=', 'uwh2.transaction_parent_id')
        ->join('users as user1', 'uwh.user_id', '=', 'user1.id')
        ->join('users as user2', 'uwh2.user_id', '=', 'user2.id')
        ->where('uwh.id', $id)
        ->get();

        return $walletData;
    }
}
