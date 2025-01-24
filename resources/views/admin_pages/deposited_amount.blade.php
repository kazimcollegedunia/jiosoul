@extends('layout.default')

@section('title', 'Dashboard')

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
                    <h4 class="text-white-heading h3">Payments List</h4>
                </div>
                <div class="pd-20">
                    <div class="text text-right">
                        <a href="{{route('total.payment.filter')}}" class="btn btn-primary">Total Payment Filter</a>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <label class="label" for="status">Status :</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="all">All</option>
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Approve</option>
                                    <option value="2">Reject</option>

                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="label" for="status">Payment Date From :</label>
                                <input
                                    class="form-control datetimepicker"
                                    placeholder="Payment Date From"
                                    type="text"
                                    name="payment_from"
                                    id="payment_from"
                                    readonly="true"
                                />
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="label" for="status">Payment Date To :</label>
                                <input
                                    class="form-control datetimepicker"
                                    placeholder="Payment Date To"
                                    type="text"
                                    name="payment_to"
                                    id="payment_to"
                                    readonly="true"
                                />
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="label" for="status">Users :</label>
                                <select class="form-control" name="user" id="user">
                                    <option value="all">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--<div class="col-sm-6 col-md-3">
                                <label class="label" for="status">Status :</label>
                                <select class="form-control">
                                    <option>Selecet Status</option>
                                    <option>Pending</option>
                                    <option>Reject</option>
                                    <option>Approve</option>
                                </select>
                            </div>-->
                        </div> 
                    </form>


                    <div class="table-responsive pt-2">
                        <table class="table table-bordered" id="user-datatable" style="width:100%">
                            <thead>
                                <tr>
                                <th>S.no</th>
                                <th>User Name</th>
                                <th>Payment ID</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Payment Date</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
          $(function(){
            $(`#status`).select2({
                theme: 'bootstrap4',
            });
            var table = $('#user-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                  url: "{{ route('deposit.datatable') }}",
                  data: function (d) {
                        d.status = $('#status').val(),
                        d.payment_from = $('#payment_from').val(),
                        d.payment_to = $('#payment_to').val(),
                        d.user = $('#user').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'id', name: 'id', searchable: true, orderable: true},
                    {data: 'name', name: 'name', searchable: true, orderable: true},
                    {data: 'payment_id', name: 'payment_id', searchable: true, orderable: true},
                    {data: 'amount', name: 'amount', searchable: true, orderable: true},
                    {data: 'payment_mode', name: 'payment_mode', searchable: true, orderable: true},
                    {data: 'payment_date', name: 'payment_date', searchable: true, orderable: true},
                    {data: 'status', name: 'status', searchable: true, orderable: true},
                ],
                "language": {
                "emptyTable": "No job found.",
                "info": "Showing _START_ to _END_ of _TOTAL_ Candidates",
                "zeroRecords": "No matching user found",
                "search": "Search Payment id",
                "lengthMenu": "Show _MENU_Candidates",
            },
            "order": [[ 0, 'aesc' ]],
            });
             $('#status, #payment_from, #payment_to, #user,#jd_availability')
                .add('#start_date, #end_date')
                .on('change blur', function() {
                    table.draw();
                });
                $('#job_description_modal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var job_id = button.data('value'); // Extract value from data-value attribute
                    
                    condition = checkCondition(job_id);
                    if(condition === "edit"){
                        $("#show_job_description").modal('hide')
                    }else{
                        console.log("else " + condition + "Job ID " + job_id);
                    }
                    $("#job_id").val(job_id);
                });
            $(`#job_name, #team,#user`).select2({
                theme: 'bootstrap4',
            });
        })
    </script>
        
@endpush
