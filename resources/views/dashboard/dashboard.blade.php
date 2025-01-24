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
            <h2 class="h3 mb-0">Jio Soul Overview</h2>

            <div class="min-height-200px" id="content">
    <!-- Default Basic Forms Start -->
    <div class="card-box mb-30">
        <div class="pd-5 bg bg-light-blue text-center">
            <h4 class="text-white-heading h3">Payment Deposit</h4>
        </div>
        <div class="pd-20">
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif

            

            <div class="form-info-div">
                <form action="{{ route('collection.store') }}" method="post" enctype="multipart/form-data" id="candidate_profile_form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <label class="col-form-label">Payment Type*</label>
                                <select class="form-control" name="payment_mode" id="payment_mode" required>
                                    <option value="" selected disabled>Select Payment Type</option>
                                    <option value="online">Online</option>
                                    <option value="cash">Cash</option>
                                </select>
                                <span id="designation_error" class="text-danger"></span>
                            </div>
                        </div>
                        @if(Auth::user()->id === 1)
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label">Select Depositor*</label>
                                    <select name="depositor_name" id="depositor_name" class="form-control">
                                        <option value="" disabled selected>Select Depositor</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} ({{$user->employee_id}})</option>
                                        @endforeach
                                    </select>
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="depositor_name" value="{{Auth::user()->id}}">
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
                                <input type="submit" class="btn btn-success btn-block">
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
    </script>
@endpush
