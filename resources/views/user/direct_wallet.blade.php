@extends('layout.default')

@section('title', 'Dashboard')

@section('content')
<style type="text/css">
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        display: none;
    }
</style>
        <div class="title pb-20">
            <h2 class="h3 mb-0">Wthdrawal Wallet Amount</h2>

            <div class="min-height-200px" id="content">
    <!-- Default Basic Forms Start -->
    <div class="card-box mb-30">
        <div class="pd-5 bg bg-light-blue text-center">
            <h4 class="text-white-heading h3">Wthdrawal Wallet Amount</h4>
        </div>
        <div class="pd-20">
            <div class="text text-right">
                <a href="{{route('wallet.amount.process')}}" class=" btn btn-info"> <i class="micon bi bi-wallet2"></i> Wallet Payment Process</a>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif

            

            <div class="form-info-div">
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

                <div id="wallet-card" class="card mt-3" style="display:none;">
                    <div class="card-body">
                        <h5 class="card-title">Wallet Details</h5>
                        <p><strong>Wallet Amount:</strong> ₹<span id="wallet-amount">0</span></p>
                    </div>
                </div>
                <form action="{{ route('wallet.wthdrawal') }}" method="post" enctype="multipart/form-data" id="candidate_profile_form">
                    @csrf
                    <div class="row">
                        @if(Auth::user()->id === 1)
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label">Select Depositor*</label>
                                    <select name="user_id" id="depositor_name" class="form-control">
                                        <option value="" disabled selected>Select Depositor</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} ({{$user->employee_id}})</option>
                                        @endforeach
                                    </select>
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        @endif
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Amount*</label>
                                <input class="form-control" type="number" placeholder="Amount" name="amount" id="amount" required>
                                <span id="name_error" class="text-danger"></span>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Proof*</label>
                                <input class="form-control" type="file" placeholder="Candidate Name" name="name" id="name">
                                <span id="name_error" class="text-danger"></span>
                            </div>
                        </div> -->
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="submit" value="Withdraw" class="btn btn-success btn-block">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row pb-10">
        
    </div>
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"></script>
    <script type="text/javascript">
        $(function(){
            $(`#depositor_name`).select2({
                theme: 'bootstrap4',
            });
        })

        $(document).ready(function() {
            $('#depositor_name').on('change', function() {
                let userId = $(this).val();

                if (!userId) return;

                $.ajax({
                    url: "{{ url('wallet/direct-wthdrawal-wallet') }}/" + userId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            console.log(response.wallet);
                            $('#wallet-amount').text(response.wallet.created.toFixed(2) ?? 0);
                            $('#wallet-card').show();
                        } else {
                            alert('Failed to fetch wallet details.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>
@endpush
