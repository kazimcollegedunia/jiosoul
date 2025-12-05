@extends('layout.default')

@section('title', 'Dashboard')

@section('content')

<style>
     .toggle-children {
            cursor: pointer;
        }
        .child-nodes {
            display: none;
            padding-left: 20px;
        }
        .icons:hover {
            color:white;
            font-size:25px;
            Background:gray;
            margin:2px;
        }
</style>
    <div class="title pb-20">
        <h2 class="h3 mb-0">User Wallet</h2>

        <div class="min-height-200px" id="content">
            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-3 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data"> 
                                <!-- dd($wallet); -->
                                <div class="weight-700 font-24 text-dark">{{$wallet['created'] ?? 0}} <i class="bi bi-currency-rupee"></i> </div>
                                <div class="font-14 text-secondary weight-500">
                                    Wallet Balence
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#ff5b5b">
                                    <span class="icon-copy fa fa-money"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$wallet['pending'] ?? 0 }} <i class="bi bi-currency-rupee"></i> </div>
                                <div class="font-14 text-secondary weight-500">
                                    Wallet Pending Balence
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#ff5b5b">
                                    <span class="icon-copy fa fa-money"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$wallet['debited'] ?? 0 }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Withdraw Amount
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i
                                        class="icon-copy fa fa-money"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$wallet['debitReq'] ?? 0 }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Withdraw Request
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i
                                        class="icon-copy fa fa-money"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30 pb-1">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">Withdraw Request</h4>
                </div>
                <p><b class="text text-danger">NOTE !</b> Wthdrawal minimum of 100 ₹.</p>                 
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success m-1">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if (Session('error'))
                        <div class="alert alert-danger m-1">
                            {{ session('error') }}
                        </div>
                @endif
                <form action="{{ route('wallet.wthdrawal') }}" method="post" enctype="multipart/form-data" id="candidate_profile_form">
                    @csrf
                    <input type="hidden" name="transaction_type" value="debit">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Amount*</label>
                                <input class="form-control" type="number" placeholder="Amount" name="amount" id="amount" value="{{old('amount')}}" required>
                                <span id="name_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-block">
                            </div>
                        </div>
                </form>
            
            </div>

            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">User last 20 Transaction History</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Payment ID</th>
                            <th>Amount</th>
                            <th>Paymant Mode</th>
                            <th>Paymant Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallet['alltransation'] ?? [] as $key => $transation)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>TID{{ $transation['id'] }}</td>
                                    <td>{{ $transation['amount'] }}</td>
                                    <td>{{ $transation['transaction_type']}}</td>
                                    <td>{{$transation['created_at']}}</td>
                                    <td>{{ $transation['status']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            

        </div>
    </div>

    <div class="row pb-10">

    </div>
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
