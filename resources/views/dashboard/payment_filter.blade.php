@extends('layout.default')

@section('title', 'Payment Filter')

@section('content')
@php
	$user = Auth::user();
@endphp
<div class="pd-ltr-20 xs-pd-20-10">
	<div class="min-height-200px">
		<div class="page-header">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="title">
						<h4>Payment Filter</h4>
					</div>
					<nav aria-label="breadcrumb" role="navigation">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{route('user.dashboard')}}">Home</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								Payment Filter
							</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
				@if(session()->has('message'))
				    <div class="alert alert-success">
				        {{ session()->get('message') }}
				    </div>
				@endif

				<div class="pd-20 card-box height-100-p">
					<form action="#" method="post" id="filter-form">
						@csrf
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
								<label class="label" for="status">Users :</label>
                                <select class="form-control" name="user" id="user">
                                    <option value="all">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{$user->fullNameWithId}}</option>
                                    @endforeach
                                </select>
                            </div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
								<label class="label" for="status">Payment Date From :</label>
	                                <input class="form-control datetimepicker" placeholder="Payment Date From" type="text" name="payment_from" id="payment_from" readonly="true"/>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
	                                <label class="label" for="status">Payment Date To :</label>
	                                <input class="form-control datetimepicker" placeholder="Payment Date To" type="text" name="payment_to" id="payment_to" readonly="true"/>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
	                                <label class="label" for="status">Submit :</label>
	                                <input type="submit" name="" class="btn btn-success btn-block">
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
							<div class="card">
								<div class="card-hearder bg bg-primary p-1">
									<h4 class="text text-white"><i class="icon-copy fa fa-check-square" aria-hidden="true"></i> Total</h4>
								</div>
								<div id="total_data" class="text text-center p-2">
									<h3>{{$filter['total']}}</h3>	
								</div>
							</div>
							
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
							<div class="card">
								<div class="card-hearder bg bg-warning p-1">
									<h4 class="text text-white"><i class="icon-copy fa fa-hourglass-1" aria-hidden="true"></i> Pending</h4>
								</div>
								<div id="pending_data" class="text text-center p-2">
									<h3>{{$filter['pending']}}</h3>	
								</div>
							</div>
							
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
							<div class="card">
								<div class="card-hearder bg bg-success p-1">
									<h4 class="text text-white"><i class="icon-copy fa fa-check-square-o" aria-hidden="true"></i> Approve</h4>
								</div>
								<div id="approve_data" class="text text-center p-2">
									<h3>{{$filter['approve']}}</h3>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
							<div class="card">
								<div class="card-hearder bg bg-danger p-1">
									<h4 class="text text-white"><i class="icon-copy fa fa-times-rectangle-o" aria-hidden="true"></i> Rejected </h4>
								</div>
								<div id="rejected_data" class="text text-center p-2">
									<h3>{{$filter['rejected']}}</h3>
								</div>
							</div>
						</div>
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
    	$(function(){
            $(`#user`).select2({
                theme: 'bootstrap4',
            });
        });
    	document.getElementById('filter-form').addEventListener('submit', function (e) {
		    e.preventDefault(); 
		    var formData = new FormData(this);

		    fetch('{{route("user.payment.filter")}}', {
		        method: 'POST',
		        body: formData
		    })
		    .then(response => response.json())
		    .then(data => {
				$('#total_data').html(`<h3>${data.filter.total}</h3>`);
				$('#pending_data').html(`<h3>${data.filter.pending}</h3>`);
				$('#approve_data').html(`<h3>${data.filter.approve}</h3>`);
				$('#rejected_data').html(`<h3>${data.filter.rejected}</h3>`);
		    })
		    .catch(error => {
		        alert(error);
		    });
		});

		function changePassword() {
		    $('#action-button').attr('onClick', 'updateDetails()');
		    $('#action-button').text('Update Details');
		    $("#update-details").hide();
		    $("#update-password").show();
		}

		function updateDetails() {
		    $('#action-button').attr('onClick', 'changePassword()');
		    $('#action-button').text('Update Password');
		    $("#update-details").show();
		    $("#update-password").hide();
		}

    	$(`#parent_id,#child_id,#designation`).select2({
                theme: 'bootstrap4',
            });
    </script>
@endpush