<?php

namespace App\Http\Controllers;

use App\Models\AmountCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\AmountCollectionService;
use App\Services\TimelineActionService;

class AmountCollectionController extends Controller
{

    protected $acService;
    protected $timelineAction;

    public function __construct(AmountCollectionService $acService,TimelineActionService $timelineAction){
        $this->acService = $acService;
        $this->timelineAction = $timelineAction;
    }

    public function index()
    {
        $date = Carbon::now();

        $users = User::count();
        $topDepositors =  []; //User::select('users.*', \DB::raw('SUM(amount) as total_amount'))
                        // ->leftJoin('amount_collections', 'users.id', '=', 'amount_collections.user_id')
                        // ->groupBy('users.id')
                        // ->orderByDesc('total_amount')
                        // ->limit(4)
                        // ->get();
                        // dd($topDepositors);
        $amount = AmountCollection::get();
        $totalColllection = $amount->sum('amount');
        $today = $amount->where('date',$date->format('Y-m-d'))->where('status',true)->sum('amount');
        $yesterday = $amount->where('date',$date->subDays(1)->format('Y-m-d'))->where('status',true)->sum('amount');
        $amountPending = $amount->where('status',false);
        $totalPendingColllection = $amountPending->sum('amount');
        $todayPending = $amountPending->where('date',$date->format('Y-m-d'))->sum('amount');
        $yesterdayPending = $amountPending->where('date',$date->subDays(1)->format('Y-m-d'))->sum('amount');
        return view('dashboard.admin_dashboard',compact('users','totalColllection','today','yesterday','topDepositors','totalPendingColllection','todayPending','yesterdayPending'));
    }

    public function userDashboard($id=null){
        $user_id = $id ?? Auth::user()->id;
        $date = Carbon::now();
        $users = User::where('id',$user_id)->count();
        $topDepositors = [];

        $totalColllection = AmountCollection::whereHas('userDetails',function($q) use($user_id){
            $q->where('id',$user_id);
        })->where('status',true)->sum('amount');

        $today = AmountCollection::where('date',$date->format('Y-m-d'))->where('status',true)->whereHas('userDetails',function($q) use($user_id){
            $q->where('id',$user_id);
        })->sum('amount');

        $yesterday = AmountCollection::where('date',$date->subDays(1)->format('Y-m-d'))->where('status',true)
        ->whereHas('userDetails',function($q) use($user_id){
            $q->where('id',$user_id);
        })->sum('amount');
            
        $childNodes = User::children($user_id); //User::tree($user_id);
        
        $data = AmountCollection::where('user_id',$user_id)->orderBy('id','desc')->paginate(10);

        return view('user.user_dashboard',compact('users','totalColllection','today','yesterday','topDepositors','childNodes','data'));
    }

    public function getUsers(Request $request)
    {
        $user = Auth::user()->id;
        $users = User::where('user_id',$user)->paginate(10);

        return response()->json($users);
    }


    public function create()
    {
        $users = User::get();
        return view('dashboard.dashboard',compact('users'));
    }
    
    public function store(Request $request)
    {
        $collection = new AmountCollection;
        $collection->payment_mode = $request->payment_mode;
        $collection->user_id = $request->depositor_name;
        $collection->amount = $request->amount;
        $collection->status = $this->isAdmin();
        $collection->submit_by = $this->isAdmin();
        $collection->date = Carbon::now()->format('Y-m-d');
        $collection->save();

        return redirect()->back()->withSuccess('User Collection stored successfully');
    }
    public function isAdmin(){
        $user = Auth::user();
        if($user->id === 1 && $user->employee_id === 'JIO101'){
            return true;
        }
            return false;

    }

    public function depositedAmount(AmountCollection $amountCollection, $status = null)
    {   
        $status = $this->status_modify($status);
        $users = User::get();
        return view('admin_pages.deposited_amount',compact('status','users'));
    }

    public function status_modify($status){
        $result =  0;

        if($status){
            $result =  1;
        }

        return $result;
    }

    public function updateDepositedAmount(Request $request, AmountCollection $amountCollection)
    {       
        $collection = $amountCollection->find($request->dep_id);
        $collection->status =  $request->status;
        $collection->save();
        $this->timelineAction->actionOn($request);
        return redirect()->back()->withSuccess('successfully');
    }

    public function depositDatatable(Request $request){
        $logedinUser = Auth::user();
        $data = AmountCollection::with('userDetails');

        if($request->status !== "all"){
            $data->where('status',$request->status);
        }

        if($request->payment_from){
            $payment_from = Carbon::parse($request->payment_from);
            $data->whereDate('date' , '>=' , $payment_from);
        }

        if($request->payment_to){
            $payment_to = Carbon::parse($request->payment_to);
            $data->whereDate('date' , '<=' , $payment_to);
        }

        if($request->user !== 'all'){
            $data->where('user_id',$request->user);
        }
        
        if (!empty($request->get('search'))) {
             $data = $data->where(function($w) use($request){
                $search = $request->get('search');
                $w->where('id', 'LIKE', "%$search%")
                ->orWhere('id', 'LIKE', "%$search%");
                // ->orWhere('mobile_no', 'LIKE', "%$search%")
                // ->orWhere('id', 'LIKE', "%$search%")
                // ->orWhere('source', 'LIKE', "%$search%")
                // ->orWhereHas('appliedFor', function ($w) use ($search){
                //     $w->WhereHas('designation', function ($w) use ($search){
                //         $w->where('designation_name', 'LIKE', "%$search%");
                //     });
                // });
            });
        }

        $acService = app(AmountCollectionService::class);

        return $this->acService->datatableData($data);
    }

    public function totalPaymentFilter(){
        $filter =  $this->acService->amountCollectionData();
        $users = User::get();
        return view('dashboard.payment_filter',compact('filter','users'));
    }

    public function paymentFilter(Request $request){
        $filter =  $this->acService->amountCollectionData($request);

        return json_encode(['filter' => $filter]);
    }
}
