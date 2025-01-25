@extends('layout.default')

@section('title', 'Dashboard')

@section('content')

    <div class="title pb-20">
        <h2 class="h3 mb-0">User Dashboard</h2>

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
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        
@endpush
