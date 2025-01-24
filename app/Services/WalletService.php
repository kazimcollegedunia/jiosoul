<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserWalletHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AmountCollection;
use DataTables;
use Illuminate\Support\Str;

class WalletService
{
    public static function walletCalculations($user_id, $type = 0)
    {
        $credit = 0;
        $debited = 0;
        $debitReq = 0;
        $allTransation = [];
        $count = $type;

        $walletData = UserWalletHistory::where('user_id', $user_id)->get();

        if ($walletData->isNotEmpty()) {
            foreach ($walletData as $key => $wallet) {
                $count++;
                if ($count <= 20) {
                    $allTransation[$key] = [
                        'id' => $wallet->id,
                        'amount' => $wallet->amount,
                        'transaction_type' => ucwords(str_replace('_', ' ', array_search($wallet->transaction_type, UserWalletHistory::Wallet_TRANSATION))),
                        'status' => array_search($wallet->status, UserWalletHistory::Wallet_STATUS),
                        'created_at' => Carbon::parse($wallet->created_at)->format('Y-m-d h:i a'),
                    ];
                }

                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['credited']) {
                    $credit += $wallet->amount;
                }
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['debited']) {
                    $debited += $wallet->amount;
                }
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['debit_request']) {
                    $debitReq += $wallet->amount;
                }
            }
        }

        rsort($allTransation);

        $finalCredit = $credit - ($debited + $debitReq);

        return [
            'credit' => $finalCredit,
            'debited' => $debited,
            'debitReq' => $debitReq,
            'allTransation' => $allTransation,
        ];
    }

    public static function checkWalletBalance($amount,$user_id){
        $type = 20; //"check balance";
        $avalibaleAmount =  self::walletCalculations($user_id,$type);
        $avalibaleAmount = (int) $avalibaleAmount['credit'];
        if($avalibaleAmount >= $amount){
            return true;
        }
        return false;
    }

}
