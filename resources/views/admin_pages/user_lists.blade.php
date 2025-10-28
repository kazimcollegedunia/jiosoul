@extends('layout.default')

@section('title', 'Dashboard')

@section('content')

    <div class="title pb-20">
        <h2 class="h3 mb-0">User Dashboard</h2>
        <div class="text text-right pb-2">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addUserModal">
                    <i class="bi bi-person-plus"></i> Add User
                </a>
        </div>

        <div class="min-height-200px" id="content">
        <!-- Default Basic Forms Start -->
            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">Pending and Approve Users Lists</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Empl ID</th>
                            <th>Name</th>
                            <th>User Parent</th>                            
                            <th>Active</th>
                            <th>Status</th>
                            <th>created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->employee_id}}</td>
                                <td>{{ ucwords($user->fullNameWithId) }}</td>
                                <td>{{ $user->userParent?$user->userParent->parent->fullNameWithId : 'NA'}}</td>
                                <td><p class="text text-{{ $user->is_active?'success':'warning'}} ">{{ $user->is_active?'Active':'Inactive'}}</td>
                                <td><p class="text text-{{ $user->status?'success':'warning'}} ">{{ $user->status?'Approved':'Pending'}}</td>
                                <td>{{ Carbon\Carbon::parse($user->created_at)->format('jS F Y h:m')}}</td>
                                <td>
                                    <a href="{{route('edit.profile',['uid' => $user->id])}}" class="btn btn-block btn-sm btn-primary">Edit <i class="icon-copy fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    <a href="{{route('user.status',['type'=> 'is_active','uid' => $user->id])}}" class="btn btn-block btn-sm btn-{{ $user->is_active?'warning':'success'}}">{{ $user->is_active?'Inactive':'Active'}}</a>
                                    <a href="{{route('user.status',['type'=> 'status','uid' => $user->id])}}" class="btn btn-block btn-sm btn-{{ $user->status?'warning':'success'}}">{{ $user->status?'Pending':'Approved'}}</a>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{$users->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>

            

        </div>
    </div>

    <div class="row pb-10">

    </div>


    <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="addUserModalLabel"><i class="bi bi-person-plus"></i> Add New User</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
            <div class="col-md-6">
              <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
            </div>
          </div>

          <div class="form-group row">
            <label for="mobile_no" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
            <div class="col-md-6">
              <input id="mobile_no" type="text" class="form-control" name="mobile_no" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
            <div class="col-md-6">
              <input id="email" type="email" class="form-control" name="email" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
              <input id="password" type="password" class="form-control" name="password" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
            <div class="col-md-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="employee_id" class="col-md-4 col-form-label text-md-right">Sponsor ID</label>
            <div class="col-md-6">
              <input id="employee_id" type="text" class="form-control" name="employee_id" placeholder="JIO101">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        
@endpush
