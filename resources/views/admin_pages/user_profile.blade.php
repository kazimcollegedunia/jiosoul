@extends('layout.default')

@section('title', 'User Profile edit')

@section('content')

    <div class="title pb-20">
        <h2 class="h3 mb-0">User Profile edit</h2>

        <div class="min-height-200px" id="content">
        <!-- Default Basic Forms Start -->
            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">Edit User Profile</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif

                 @if(session('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach(session('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <div class="text text-right m-2">
                        <a href="javascript:void(0)" class="btn btn-success" onclick="showUserProfile('parent_child')">Assign Parent</a>
                    </div>
                    <div class="m-2">
                        <h5>Employee Id : {{$user->employee_id}}</h5>
                    </div>
                
                    <form action="{{route('user.change.password')}}" method="post">
                        @csrf
                        <input type="hidden" name="uid" value="{{$user->id}}">
                        <div class="row m-2">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="label" for="name">Name :</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control" />
                                    @error('name') 
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                     @enderror
                                </div>
                            </div>

                             <div class="col-sm-12 col-md-4" id="password_container">
                                <div class="form-group">
                                    <label class="label text text-danger" for="password"><b class="">Create New Password* :</b></label>
                                    <input type="text" name="password"  class="form-control" />
                                    @error('password') 
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="submit" name="" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                        
                    </form>

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
        function showUserProfile(type) {
            let containerId = `${type}FormContainer`;
            $(`#${containerId}`).show();
        }
</script>
@endpush
