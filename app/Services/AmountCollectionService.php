<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AmountCollection;
use DataTables;
use Illuminate\Support\Str;


class AmountCollectionService
{
    public function adminDashboard(){
        $datas = ['topDepositors','date','users','totalColllection','today','yesterday'];

        return $datas;
    }

    public function datatableData($data){
        $dataTable =  Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('name', function ($row) {
              return ucwords($row->userDetails->name);
            })
            ->editColumn('amount', function ($row) {
              return $row->amount;
            })
            ->editColumn('status', function ($row) {
                return self::datatableActionButton($row);
            })
            ->editColumn('payment_id', function ($row) {
              return "JIO-DEP10".$row->id;
            })
            ->editColumn('payment_mode', function ($row) {
              return Str::headline($row->payment_mode);
            })
            ->editColumn('payment_date', function ($row) {
              return $row->date;
            })

            ->rawColumns(['status'])
            ->make(true);
        return $dataTable;
    }

    public static function datatableActionButton($row){
        $btn = '';
        if(!$row->status){
            $btn .='<a href="'.route('update-deposited-amount', ['dep_id' => $row->id, 'status' => 1]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
        }

        if($row->status == 1 || !$row->status){
            $btn .= '<a href="'.route('update-deposited-amount', ['dep_id' => $row->id, 'status' => 2]) .'" class="btn btn-sm btn-danger btn-block" onclick="return confirm(`Are you sure you want to Reject pending payment?`)">Reject</a>';
        }

        if($row->status == 2){
            $btn .='<a href="'.route('update-deposited-amount', ['dep_id' => $row->id, 'status' => 1]) .'" class="btn btn-sm btn-success btn-block" onclick="return confirm(`Are you sure you want to Approve pending payment?`)">Approve</a>';
            }
        return $btn;
    }

    public function amountCollectionData($request = null){
        $amount = AmountCollection::query();
        if($request){
             $payment_from = Carbon::parse($request->payment_from);
             $payment_to = Carbon::parse($request->payment_to);
             $amount = $amount->whereBetween('date', [$payment_from, $payment_to]);
             if($request->user && $request->user !== 'all'){
                $amount = $amount->where('user_id' , $request->user);
             }
        }

        $amount = $amount->get();

        $filter['total'] = $amount->sum('amount');
        $filter['approve'] = $amount->where('status',AmountCollection::APPROVE)->sum('amount');
        $filter['pending'] = $amount->where('status',AmountCollection::PENDING)->sum('amount');
        $filter['rejected'] = $amount->where('status',AmountCollection::REJECTED)->sum('amount');

        return $filter;
    }
}
