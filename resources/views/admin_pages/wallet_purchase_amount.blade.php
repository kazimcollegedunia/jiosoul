@extends('layout.default')

@section('title', 'Amount Details')

@section('content')
    <div class="title pb-20">
        <div class="text-right m-1">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>
        <div class="min-height-200px" id="content">
            <!-- Default Basic Forms Start -->
            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">Payments Details</h4>
                </div>
                <div class="pd-20">
                    <div class="text text-right">
                        <!-- <a href="" class=" btn btn-info"> <i class="micon bi bi-wallet2"></i> Wallet Payment Process</a> -->
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transaction ID: {{ $payments['users']->transaction_id }} - <strong>Amount:</strong> {{ $payments['users']->purchase_amount }} RS</h5>

                                <p class="card-text"><strong>Total Distribution Amount:</strong> {{ $payments['totalDistributionAmount'] }} RS</p>
                                <p class="card-text"><strong>Actual Amount :</strong> {{ $payments['totalDistributionAmount'] - $payments['users']->purchase_amount }}</p>
                                <p class="card-text"><strong>Status:</strong>  {{ ucwords(array_search($payments['users']->status,App\Models\UserWalletHistory::Wallet_STATUS)) }}</p>
                                <p class="card-text"><strong>Created At:</strong> {{ $payments['users']->created_at }}</p>
                            <hr>
                            @foreach($payments['fullDetails'] as $key => $payment)
                                <div class="car-header">
                                    <strong> User-({{++$key}})</strong>
                                </div>
                                <div class="card m-1 p-1">
                                    <p class="card-text"><strong>User Name:</strong> {{$payment->transfer_user}}</p>
                                    <p class="card-text"><strong>Amount:</strong> {{$payment->transfer_amount}} RS</p>
                                    <p class="card-text"><strong>Transaction ID:</strong> {{$payment->tran_id}}</p>
                                    <p class="card-text"><strong>Status:</strong> {{ucwords(array_search($payment->transfer_status,App\Models\UserWalletHistory::Wallet_STATUS))}}</p>
                                    <p class="card-text"><strong>Created At:</strong> {{$payment->transfer_created_at}}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="text text-center m-1">
                            <a href="{{route('wallet.all.amount.update',['id' => $payments['users']->transaction_id ,'status' => App\Models\UserWalletHistory::Wallet_STATUS['approve']])}}" class="btn btn-success">Approve All</a>
                            <a href="{{route('wallet.all.amount.update',['id' => $payments['users']->transaction_id ,'status' => App\Models\UserWalletHistory::Wallet_STATUS['rejected']])}}" class="btn btn-danger">Reject All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"></script>

    <script type="text/javascript">
        
    </script>
        
@endpush
