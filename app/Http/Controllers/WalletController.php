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

        $loggedInUser = Auth::user();
        $isAdmin = $loggedInUser->id === 1;

        // Determine target user
        $user_id = $isAdmin && $request->has('user_id') 
            ? $request->user_id
            : $loggedInUser->id;

        // Validation
       $rules = [
            'transaction_type' => 'required|in:credit,debit',
            'amount' => 'required|numeric'
        ];

        // If DEBIT → add min:100
        if ($request->transaction_type === 'debit') {
            $rules['amount'] .= '|min:100';
        }

        $validated = $request->validate($rules, [
            'amount.min' => "Amount should be minimum 100 ₹"
        ]);

        $amount = $request->amount;
        $txnType = $request->transaction_type;  // NEW dynamic selection

        /**
         *  ⭐ CASE 1 : CREDIT (ADD WALLET AMOUNT)
         *  --------------------------------------
         *  If admin/user selects "credit", then we simply 
         *  credit the amount and stop.
         */
        if ($txnType === 'credit') {

            $walletTxn = new UserWalletHistory();
            $walletTxn->user_id = $user_id;
            $walletTxn->amount = $amount;
            $walletTxn->transaction_type = UserWalletHistory::Wallet_TRANSATION['credited'];
            $walletTxn->status = UserWalletHistory::Wallet_STATUS['approve'];
            $walletTxn->save();

            // Immediately add to wallet balance
            // $this->walletService::addWalletBalance($user_id, $amount);

            return redirect()->back()->withSuccess('Amount credited successfully to the wallet.');
        }

        /**
         *  ⭐ CASE 2 : DEBIT (Your Existing Logic)
         *  ---------------------------------------
         *  Nothing changed here — your full original debit 
         *  process is exactly same as before.
         */

        // Check wallet balance before debit
        $isAvailable = $this->walletService::checkWalletBalance($amount, $user_id);
        if (!$isAvailable) {
            return redirect()->back()->withError('The wallet balance should be at least ' . $amount . ' ₹');
        }

        // Admin → Debit instantly with pending status
        if ($isAdmin) {

            $walletTxn = new UserWalletHistory();
            $walletTxn->user_id = $user_id;
            $walletTxn->amount = $amount;
            $walletTxn->transaction_type = UserWalletHistory::Wallet_TRANSATION['debit_request'];
            $walletTxn->status = UserWalletHistory::Wallet_STATUS['pending'];
            $walletTxn->save();

            // debit can be instantly updated if needed:
            // $this->walletService::deductWalletBalance($user_id, $amount);

            return redirect()->back()->withSuccess('Amount successfully withdrawn from user wallet (status pending).');
        }

        // Normal user → pending withdrawal request
        $walletTxn = new UserWalletHistory();
        $walletTxn->user_id = $user_id;
        $walletTxn->amount = $amount;
        $walletTxn->transaction_type = UserWalletHistory::Wallet_TRANSATION['debit_request'];
        $walletTxn->status = UserWalletHistory::Wallet_STATUS['pending'];
        $walletTxn->save();

        return redirect()->back()->withSuccess('Request sent successfully. Amount will be debited after approval.');
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
