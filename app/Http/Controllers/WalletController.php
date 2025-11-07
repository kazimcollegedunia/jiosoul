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
    // public function walletWthdrawal(Request $request){
    //     $user_id =  Auth::user()->id;

    //     $validated = $request->validate([
    //         'amount' => 'required|integer|min:100',
    //     ],[
    //         'amount.min' => "Amount should be minmum 100 ₹"
    //     ]);

    //     $amount = $request->amount;
    //     $is_avalibale_amount = $this->walletService::checkWalletBalance($amount,$user_id);
    //     if(!$is_avalibale_amount){
    //         return redirect()->back()->withError('The wallet balance should be at least '.$amount.' ₹');
    //     }

    //     $userWalletHistory = New UserWalletHistory;
    //     $userWalletHistory->user_id =  $user_id;
    //     $userWalletHistory->amount =  $amount;
    //     $userWalletHistory->transaction_type =  UserWalletHistory::Wallet_TRANSATION['debit_request'];
    //     $userWalletHistory->status =  UserWalletHistory::Wallet_STATUS['pending'];
    //     $userWalletHistory->save();

    //     return redirect()->back()->withSuccess('Request Sent Successfull Amount will credit on your AC');
        
    // }

    public function walletWthdrawal(Request $request)
    {
        // dd($request->all());
        // ✅ Check if admin is sending request or user
        $loggedInUser = Auth::user();
        $isAdmin = $loggedInUser->id === 1; // adjust field name as per your table

        // ✅ Determine which user’s wallet to withdraw from
        $user_id = $isAdmin && $request->has('user_id') 
            ? $request->user_id   // admin can choose any user
            : $loggedInUser->id;  // normal user

        // ✅ Validation
        $validated = $request->validate([
            'amount' => 'required|integer|min:100',
        ], [
            'amount.min' => "Amount should be minimum 100 ₹"
        ]);

        $amount = $request->amount;

        // ✅ Check wallet balance
        $isAvailable = $this->walletService::checkWalletBalance($amount, $user_id);
        if (!$isAvailable) {
            return redirect()->back()->withError('The wallet balance should be at least ' . $amount . ' ₹');
        }

        // ✅ If Admin → directly approve and debit
        if ($isAdmin) {
            $walletTxn = new UserWalletHistory();
            $walletTxn->user_id = $user_id;
            $walletTxn->amount = $amount;
            $walletTxn->transaction_type = UserWalletHistory::Wallet_TRANSATION['debit_request'];
            $walletTxn->status = UserWalletHistory::Wallet_STATUS['pending'];
            // $walletTxn->approved_by = $loggedInUser->id; // optional: who approved
            $walletTxn->save();

            // ✅ Update user wallet balance instantly
            // $this->walletService::deductWalletBalance($user_id, $amount);

            return redirect()->back()->withSuccess('Amount successfully withdrawn from user wallet (status pending).');
        }

        // ✅ If Normal User → pending request (existing flow)
        $walletTxn = new UserWalletHistory();
        $walletTxn->user_id = $user_id;
        $walletTxn->amount = $amount;
        $walletTxn->transaction_type = UserWalletHistory::Wallet_TRANSATION['debit_request'];
        $walletTxn->status = UserWalletHistory::Wallet_STATUS['pending'];
        $walletTxn->save();

        return redirect()->back()->withSuccess('Request sent successfully. Amount will be credited upon approval.');
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
            $status = UserWalletHistory::Wallet_STATUS['pending']; 
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
        $is_wallet = isset($request->is_wallet) ? $request->is_wallet :  false;
        $data = $this->walletService->datatableDataQuery($request);
       return  $this->walletService->datatableData($data,$is_wallet);
    }

    public function updatepurchaseAmount($id,$status){
        $userWalletHistory =  UserWalletHistory::find($id);
        if(empty($userWalletHistory->transaction_parent_id) && $status == UserWalletHistory::Wallet_STATUS['approve']){
            $this->walletService::amountDistribute($userWalletHistory);
        }
        // dd($userWalletHistory);

        $userWalletHistory->status =  $status;
        $userWalletHistory->save();
        return redirect()->back()->withSuccess('updated successfull');
    }

    public function viewPurchaseAmount($id){
        $userWalletHistory =  UserWalletHistory::walletAmountDetails($id);
            $payments = [];
        if(count($userWalletHistory) && !empty($userWalletHistory)){
            $payments['users'] = $userWalletHistory ? $userWalletHistory[0] : [];
            $payments['fullDetails'] = $userWalletHistory ?? [];
            $payments['totalDistributionAmount'] = $this->walletService->purchaseAmountDistribution($userWalletHistory);
        }
        
        return view('admin_pages.wallet_purchase_amount',compact('payments'));
    }

    public function walletAmountProcess(){
        $status =  UserWalletHistory::Wallet_STATUS;
        $users = User::get();
        return view('admin_pages.wallet_amount_process',compact('status','users'));
    }

    public function walletAllAmountUpdate($id,$status){
        $this->walletService->updateParentTransactionId($id,$status);

        return redirect()->back()->withSuccess('updated successfull');
    }

    public function directwalletWthdrawal($id = null)
    {
        $users = User::get();
        $wallet = [];

        if (!empty($id)) {
            $wallet = $this->walletService::walletCalculations($id);

            // Return JSON if it's an AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'wallet' => $wallet
                ]);
            }
        }

        return view('user.direct_wallet', compact('users', 'wallet'));
    }

}
