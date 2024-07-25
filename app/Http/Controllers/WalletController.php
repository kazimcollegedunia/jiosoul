<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Support\Facades\Log;
use App\Models\UserWalletHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class WalletController extends Controller
{

    protected $walletService;

    public function __construct(WalletService $walletService){
        $this->walletService = $walletService;
    }

    public function userWallet(){
        $user_id =  Auth::user()->id;
        $wallet = $this->walletService::walletCalculations($user_id);
        return view('user.user_wallet',compact('wallet'));
    }
    public function walletWthdrawal(Request $request){
        $user_id =  Auth::user()->id;

        $validated = $request->validate([
            'amount' => 'required|integer|min:100',
        ],[
            'amount.min' => "Amount should be minmum 100 ₹"
        ]);

        $amount = $request->amount;
        $is_avalibale_amount = $this->walletService::checkWalletBalance($amount,$user_id);
        if(!$is_avalibale_amount){
            return redirect()->back()->withError('The wallet balance should be at least '.$amount.' ₹');
        }

        $userWalletHistory = New UserWalletHistory;
        $userWalletHistory->user_id =  $user_id;
        $userWalletHistory->amount =  $amount;
        $userWalletHistory->transaction_type =  UserWalletHistory::Wallet_TRANSATION['debit_request'];
        $userWalletHistory->status =  UserWalletHistory::Wallet_STATUS['pending'];
        $userWalletHistory->save();

        return redirect()->back()->withSuccess('Request Sent Successfull Amount will credit on your AC');
        
    }

    public function addWalletAmount(){
        $user_id =  Auth::user()->id;
        $users = User::get();
        $wallet = $this->walletService::assetPurchaseCalculations($user_id);
        return view('user.add_wallet_amount',compact('wallet','users'));
    }

    public function addWalletAmountStore(Request $request){
        $user_id =  Auth::user()->id;
        $status = UserWalletHistory::Wallet_STATUS['pending'];

        $validated = $request->validate([
            'amount' => 'required|integer|min:100',
        ],[
            'amount.min' => "Amount should be minmum 100 ₹"
        ]);

        $amount = $request->amount;

        $userWalletHistory = New UserWalletHistory;
        if(!empty($request->user_id)){
            $user_id =  $request->user_id;
            $status = UserWalletHistory::Wallet_STATUS['approve'];
        }
        $userWalletHistory->user_id =  $user_id;
        $userWalletHistory->amount =  $amount;
        $userWalletHistory->transaction_type =  UserWalletHistory::Wallet_TRANSATION['purchase_amount'];
        $userWalletHistory->status = $status;
        $userWalletHistory->save();

        return redirect()->back()->withSuccess('Request Sent Successfull Amount will credit on your AC');
    }

    public function purchaseAmountList()
    {   
        $status =  UserWalletHistory::Wallet_STATUS;
        $users = User::get();
        return view('admin_pages.purchase_amount',compact('status','users'));
    }

    public function purchaseAmountDatatable(Request $request){

        $data = UserWalletHistory::with('userDetails')
                ->where('transaction_type',UserWalletHistory::Wallet_TRANSATION['purchase_amount']);
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

       return  $this->walletService->datatableData($data);
    }

    public function updatepurchaseAmount($id,$status){
        $userWalletHistory =  UserWalletHistory::find($id);
        if($status == UserWalletHistory::Wallet_STATUS['approve']){
            $this->walletService::amountDistribute($userWalletHistory);
        }
        $userWalletHistory->status =  $status;
        $userWalletHistory->save();
        return redirect()->back()->withSuccess('updated successfull');
    }
}
