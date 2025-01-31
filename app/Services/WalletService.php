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
    public static function walletCalculations($user_id = null, $type = 0)
    {
        $allTransation = [];
        $finalData = [];
        $count = $type;
    
        $walletData = UserWalletHistory::where('transaction_type', '!=', UserWalletHistory::Wallet_TRANSATION['purchase_amount'])
        ->where('status', '!=', UserWalletHistory::Wallet_STATUS['rejected'])->get();
    
        if ($walletData->isNotEmpty()) {
            foreach ($walletData as $key => $wallet) {
                // Initialize user array values
                if (!isset($user[$wallet->user_id])) {
                    $user[$wallet->user_id] = [
                        'credit' => 0,
                        'creditPending' => 0,
                        'debited' => 0,
                        'debitReq' => 0
                    ];
                    $allTransation[$wallet->user_id] = [];
                }
    
                $count++;
                if ($count <= 20) {
                    $allTransation[$wallet->user_id][$key] = [
                        'id' => $wallet->id,
                        'amount' => $wallet->amount,
                        'transaction_type' => ucwords(str_replace('_', ' ', array_search($wallet->transaction_type, UserWalletHistory::Wallet_TRANSATION))),
                        'status' => array_search($wallet->status, UserWalletHistory::Wallet_STATUS),
                        'created_at' => Carbon::parse($wallet->created_at)->format('Y-m-d h:i a'),
                    ];
                }
    
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['credited']) {
                    $user[$wallet->user_id]['credit'] += $wallet->amount;
                }
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['debited']) {
                    $user[$wallet->user_id]['debited'] += $wallet->amount;
                }
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['debit_request']) {
                    $user[$wallet->user_id]['debitReq'] += $wallet->amount;
                }
                if ($wallet->transaction_type === UserWalletHistory::Wallet_TRANSATION['credited'] && $wallet->status === UserWalletHistory::Wallet_STATUS['pending']) {
                    $user[$wallet->user_id]['creditPending'] += $wallet->amount;
                }
    
                $user[$wallet->user_id]['finalCredit'] = $user[$wallet->user_id]['credit']  - ($user[$wallet->user_id]['debited'] + $user[$wallet->user_id]['debitReq'] + $user[$wallet->user_id]['creditPending']);
    
                rsort($allTransation[$wallet->user_id]);
    
                $finalData[$wallet->user_id] = [
                    'alltransation' => $allTransation[$wallet->user_id],
                    'created' => $user[$wallet->user_id]['finalCredit'],
                    'debited' => $user[$wallet->user_id]['debited'],
                    'debitReq' => $user[$wallet->user_id]['debitReq'],
                    'pending' => $user[$wallet->user_id]['creditPending']
                ];
            }
        }
    
        return $user_id !== null ? ($finalData[$user_id] ?? []) : $finalData;
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
        if(!empty($avalibaleAmount)){
            $avalibaleAmount = (int) $avalibaleAmount['created'];
            if($avalibaleAmount >= $amount){
                return true;
            }
        }
        return false;
    }

    public function datatableDataQuery($request){
        // $transaction_type =  'purchase_amount';
        $data = UserWalletHistory::with('userDetails');
        if(!$request->is_wallet){
            $data = $data->where('transaction_type',UserWalletHistory::Wallet_TRANSATION['purchase_amount']);
        }else{
            $data = $data->where('transaction_type','!=',UserWalletHistory::Wallet_TRANSATION['purchase_amount']);

        }
                
        if($request->status !== "all"){
            $data->where('status',$request->status);
        }
        if($request->payment_from){
            $payment_from = Carbon::parse($request->payment_from);
            $data->whereDate('created_at' , '>=' , $payment_from);
        }

        if($request->payment_to){
            $payment_to = Carbon::parse($request->payment_to);
            $data->whereDate('created_at' , '<=' , $payment_to);
        }

        if($request->user !== 'all'){
            $data->where('user_id',$request->user);
        }
        
        if (!empty($request->get('search'))) {
             $data = $data->where(function($w) use($request){
                $search = $request->get('search');
                $w->where('id', 'LIKE', "%$search%")
                ->orWhere('id', 'LIKE', "%$search%");
            });
        }

        return $data;
    }

    public function datatableData($data,$is_wallet = null){
        $dataTable =  Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('id', function ($row){
                return $row->id;
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
            ->editColumn('transation_type', function ($row) {
                return ucwords(array_search($row->transaction_type, UserWalletHistory::Wallet_TRANSATION)); //$row->transaction_type;
              })
            ->editColumn('action', function ($row) use($is_wallet){
                
                return self::datatableActionButton($row,$is_wallet);
            })
            ->rawColumns(['action'])
            ->make(true);
        return $dataTable;
    }


    public static function datatableActionButton($row, $is_wallet = null){
        $btn = '';
        if($row->status == UserWalletHistory::Wallet_STATUS['rejected']){
            $btn .='<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' =>  UserWalletHistory::Wallet_STATUS['approve']]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
        }

        if($row->status == UserWalletHistory::Wallet_STATUS['approve'] || !$row->status){
            $btn .= '<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' => UserWalletHistory::Wallet_STATUS['rejected']]) .'" class="btn btn-sm btn-danger btn-block" onclick="return confirm(`Are you sure you want to Reject pending payment?`)">Reject</a>';
            if(!$is_wallet){
                $btn .='<a href="'.route('view.purchase.amount', ['id' => $row->id]) .'" class="btn btn-sm btn-success btn-block">View</a>';
            }
            
        }

        if($row->status == UserWalletHistory::Wallet_STATUS['pending']){
            $btn .='<a href="'.route('update.purchase.amount', ['id' => $row->id, 'status' => UserWalletHistory::Wallet_STATUS['approve']]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
            }
        return $btn;
    }

    public static function amountDistribute($wallet)
    {
        $amount = $wallet->amount ?? 0;
        $transaction_parent_id = $wallet->id;
        // Fetch parents up the hierarchy
        $userParents = User::parents($wallet->user_id);
        
        self::selfAmountDistribute($wallet->user_id,$amount,$transaction_parent_id);
        
        // Define the percentages for each level
        $percentages = [0.009, 0.006, 0.003]; // First, second, third level percentages

        // Start distribution from the top-level parent
        self::distributeAmount($amount, $userParents, $percentages, 0,$transaction_parent_id);
    }

    private static function distributeAmount($amount, $parents, $percentages, $level,$transaction_parent_id)
    {
        if (empty($parents) || $level >= count($percentages)) {
            return;
        }

        foreach ($parents as $parent) {
            $distributedAmount = $amount * $percentages[$level];
            
            // Update the parent's wallet
            self::updateWallet($parent['user_id'], $distributedAmount,$transaction_parent_id);
            
            // Recursively distribute to the next level
            if (!empty($parent['parents'])) {
                self::distributeAmount($amount, $parent['parents'], $percentages, $level + 1,$transaction_parent_id);
            }
        }
    }

    public static function selfAmountDistribute($user_id,$amount,$transaction_parent_id){
        $amount =  $amount * 0.03;
        self::updateWallet($user_id,$amount,$transaction_parent_id);
    }

    private static function updateWallet($user_id, $amount,$transaction_parent_id)
    {
        $wallet = new UserWalletHistory;
        if ($wallet) {
            $wallet->user_id = $user_id;
            $wallet->transaction_type = UserWalletHistory::Wallet_TRANSATION['credited'];
            $wallet->status = UserWalletHistory::Wallet_STATUS['pending'];
            $wallet->transaction_parent_id = $transaction_parent_id;
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

    public function purchaseAmountDistribution($datas){
        $transfer_amount = 0;
        foreach($datas as $data){
            $transfer_amount += $data->transfer_amount;
        }
        return $transfer_amount;
    }

    public function updateParentTransactionId($id, $status){
        UserWalletHistory::where(function ($query) use ($id) {
            $query->where('transaction_parent_id', $id)
                  ->orWhere('id', $id);
        })->update(['status' => $status]);
    }
    
}

