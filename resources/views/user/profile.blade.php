@extends('layout.default')

@section('title', 'User Profile')

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
						<h4>Profile</h4>
					</div>
					<nav aria-label="breadcrumb" role="navigation">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{route('user.dashboard')}}">Home</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								Profile
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

				<div class="pd-5 bg bg-light-blue text-center">
					<h4 class="text-white-heading h3"  id="profile-title">Update Detail</h4>
				</div>
				<div class="pd-20 card-box height-100-p">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
							<select id="call-update-form" class="form-control">
								<option value="details">Update Details</option>
								<option value="password">Update Password</option>
								<option value="bank">Update Bank Detail</option>
							  </select>
							<!-- <button onclick="changePassword()" class="btn btn-success" id="action-button">Update Password</button>
							<button onclick="updateBankDetails()" class="btn btn-info" id="action-button">Update Bank Details</button> -->
						</div>
					</div>
					<div id="update-password" style="display: none;">
						<form action="{{route('user.profile.password.update')}}" method="post">
							@csrf
							
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
								<label for="new_password" class="aria-label text-green">New Password </label>
								<input type="text" class="form-control" name="new_password" id="new_password" placeholder="new password" required>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
								<input type="submit" name="" class="btn btn-success btn-block">
							</div>
						</form>
					</div>

					<div id="update-bank-details" style="display: none;">
						<form action="{{route('user.profile.password.update')}}" method="post">
							@csrf
							
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
								<label for="ac_number" class="aria-label text-green">AC number </label>
								<input type="text" class="form-control" name="ac_number" id="ac_number" placeholder="AC Number" required>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
								<label for="ifsc_code" class="aria-label text-green">IFSC Code </label>
								<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" required>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
								<input type="submit" name="" class="btn btn-success btn-block">
							</div>
						</form>
					</div>


					<div id="update-details">
						<form action="{{route('user.profile.update')}}" method="post">
							@csrf
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="employee_id" class="aria-label text-green">Employee id </label>
									<input type="text" class="form-control" name="employee_id" id="employee_id" value="{{ucwords($user->employee_id)}}" readonly>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="name" class="aria-label text-green">Name: </label>
									<input type="text" class="form-control" name="name" id="name" value="{{ucwords($user->name)}}" readonly>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="email" class="aria-label text-green">Email: </label>
									<input type="text" class="form-control" name="email" id="email" value="{{ucwords($user->email)}}">
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="mobile_no" class="aria-label text-green">Mobile No: </label>
									<input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{ucwords($user->mobile_no)}}">
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="designation" class="aria-label text-green">Designation: </label>
									<select class="form-control" name="designation" id="designation">
										<option value="" selected disabled>Select Designation</option>
										<option>Driver</option>
										<option>Plamber</option>
										<option>Electrician</option>
									</select>
								</div>
								@role('super-admin')
									<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
										<label for="parent_id" class="aria-label text-green">Parent: </label>
										<select class="form-control" name="parent_id" id="parent_id">
											<option value="" selected disabled>Select Parent</option>
											@foreach($users as $parent)
												<option value="{{$parent->id}}" {{ $user->parent_id === $parent->id?'selected':''}} >{{$parent->fullNameWithId}}</option>
											@endforeach
										</select>
									</div>
								@endrole
								<!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
									<label for="child_id" class="aria-label text-green">Child: </label>
									<select class="form-control" name="child_id" id="child_id">
										<option value="" selected disabled>Select Parent</option>
										@foreach($users as $child)
											<option id="{{$child->id}}">{{$child->fullNameWithId}}</option>
										@endforeach
									</select>
								</div> -->
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
									<input type="submit" name="" class="btn btn-success btn-block">
								</div>
							</div>
						</form>
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

		document.getElementById('call-update-form').addEventListener('change', function () {
			const selectedValue = this.value;

			if (selectedValue === 'details') {
			updateDetails();
			} else if (selectedValue === 'password') {
			changePassword();
			} else if (selectedValue === 'bank') {
			updateBankDetails();
			}
		});
		
		function changePassword() {
			console.log('change password');
		    $('#action-button').attr('onClick', 'updateDetails()');
		    $('#action-button').text('Update Details');
		    $("#update-details").hide();
		    $("#update-password").show();
			$("#update-bank-details").hide();
			$('#profile-title').text('Update Password');
		}

		function updateDetails() {
		    $('#action-button').attr('onClick', 'changePassword()');
		    $('#action-button').text('Update Password');
		    $("#update-details").show();
		    $("#update-password").hide();
			$("#update-bank-details").hide();
			$('#profile-title').text('Update Detail');
		}

		function updateBankDetails(){
			console.log("clicked");
			$('#action-button').attr('onClick', 'updateDetails()');
		    $('#action-button').text('Update Details');
		    $("#update-bank-details").show();
		    $("#update-password").hide();
		    $("#update-details").hide();
			$('#profile-title').text('Update Bank Details');

		}

    	$(`#parent_id,#child_id,#designation`).select2({
                theme: 'bootstrap4',
            });
    </script>
@endpush