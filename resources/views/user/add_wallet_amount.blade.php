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
        <h2 class="h3 mb-0">Add Asset Amount</h2>

        <div class="min-height-200px" id="content">

            <div class="card-box mb-30 pb-1">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">Add Asset Amount</h4>
                </div>
                <p><b class="text text-danger">NOTE !</b> After approval from the admin, it will appear on your dashboard.</p>                 
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
                <form action="{{ route('add.wallet.amount.store') }}" method="post" enctype="multipart/form-data" id="candidate_profile_form">
                    @csrf
                        @role('super-admin')
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="user_id" class="aria-label">User: </label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        <option value="" selected disabled>Select user</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $user->user_id === $user->id?'selected':''}} >{{$user->fullNameWithId}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>    
                        @endrole
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Add Amount*</label>
                                <input class="form-control" type="number" placeholder="Add Amount" name="amount" id="amount" value="{{old('amount')}}" required>
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
                            @foreach ($wallet['allTransation'] as $key => $transation)
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(`#user_id`).select2({
            theme: 'bootstrap4',
        });
    </script>
@endpush
