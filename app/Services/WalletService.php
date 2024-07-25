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

        $walletData = UserWalletHistory::where('user_id', $user_id)->where('transaction_type','!=',UserWalletHistory::Wallet_TRANSATION['purchase_amount'])->get();

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

    public static function assetPurchaseCalculations($user_id, $type = 0)
    {
        $purchase = 0;
        $allTransation = [];
        $count = $type;

        $walletData = UserWalletHistory::where('user_id', $user_id)->where('transaction_type',UserWalletHistory::Wallet_TRANSATION['purchase_amount'])->get();

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
                $purchase += $wallet->amount;
            }
        }

        rsort($allTransation);

        return [
            'purchase' => $purchase,
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

    public function datatableData($data){
        $dataTable =  Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('id', function ($row) {
                return 'TID'.$row->id;
            })
            ->editColumn('user_name', function ($row) {
                return $row->userDetails->fullNameWithId;
              })
            ->editColumn('amount', function ($row) {
              return $row->amount;
            })
            ->editColumn('status', function ($row) {
                return ucwords(array_search($row->status, UserWalletHistory::Wallet_STATUS));
            })
            ->editColumn('tid', function ($row) {
                return 'TID'.$row->id;
            })
            ->editColumn('payment_mode', function ($row) {
              return Str::headline($row->payment_mode);
            })
            ->editColumn('payment_date', function ($row) {
              return $row->date;
            })
            ->editColumn('action', function ($row) {
                return self::datatableActionButton($row);
            })
            ->rawColumns(['action'])
            ->make(true);
        return $dataTable;
    }


    public static function datatableActionButton($row){
        $btn = '';
        if($row->status == UserWalletHistory::Wallet_STATUS['rejected']){
            $btn .='<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' =>  UserWalletHistory::Wallet_STATUS['approve']]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
        }

        if($row->status == UserWalletHistory::Wallet_STATUS['approve'] || !$row->status){
            $btn .= '<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' => UserWalletHistory::Wallet_STATUS['rejected']]) .'" class="btn btn-sm btn-danger btn-block" onclick="return confirm(`Are you sure you want to Reject pending payment?`)">Reject</a>';
        }

        if($row->status == UserWalletHistory::Wallet_STATUS['pending']){
            $btn .='<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' => UserWalletHistory::Wallet_STATUS['approve']]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
            }
        return $btn;
    }

    public static function amountDistribute($wallet)
    {
        // Fetch parents up the hierarchy
        $userParents = User::parents($wallet->user_id);
        
        // Define the percentages for each level
        $percentages = [0.009, 0.006, 0.003]; // First, second, third level percentages

        // Start distribution from the top-level parent
        self::distributeAmount($wallet->amount, $userParents, $percentages, 0);
    }

    private static function distributeAmount($amount, $parents, $percentages, $level)
    {
        if (empty($parents) || $level >= count($percentages)) {
            return;
        }

        foreach ($parents as $parent) {
            $distributedAmount = $amount * $percentages[$level];
            
            // Update the parent's wallet
            self::updateWallet($parent['user_id'], $distributedAmount);
            
            // Recursively distribute to the next level
            if (!empty($parent['parents'])) {
                self::distributeAmount($amount, $parent['parents'], $percentages, $level + 1);
            }
        }
    }

    private static function updateWallet($user_id, $amount)
    {
        $wallet = new UserWalletHistory;
        if ($wallet) {
            $wallet->user_id = $user_id;
            $wallet->transaction_type = UserWalletHistory::Wallet_TRANSATION['credited'];
            $wallet->status = UserWalletHistory::Wallet_STATUS['approve'];;
            $wallet->amount =  $amount;
            $wallet->save();
        }
    }

    public static function amountDeduct($wallet)
    {
        // Fetch parents up the hierarchy
        $userParents = User::parents($wallet->user_id);
        
        // Define the percentages for each level
        $percentages = [0.009, 0.006, 0.003]; // First, second, third level percentages

        // Start deduction from the top-level parent
        self::deductAmount($wallet->amount, $userParents, $percentages, 0);
    }

    private static function deductAmount($amount, $parents, $percentages, $level)
    {
        if (empty($parents) || $level >= count($percentages)) {
            return;
        }

        foreach ($parents as $parent) {
            $deductedAmount = $amount * $percentages[$level];
            
            // Update the parent's wallet
            self::updateWallet($parent['user_id'], - $deductedAmount);
            
            // Recursively deduct from the next level
            if (!empty($parent['parents'])) {
                self::deductAmount($amount, $parent['parents'], $percentages, $level + 1);
            }
        }
    }
}

