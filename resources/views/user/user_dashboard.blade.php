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
        <h2 class="h3 mb-0">User Dashboard</h2>

        <div class="min-height-200px" id="content">
        <!-- Default Basic Forms Start -->
            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$totalColllection}} + </div>
                                <div class="font-14 text-secondary weight-500">
                                    Total Collection
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
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$today}}+</div>
                                <div class="font-14 text-secondary weight-500">
                                    Today Total Collection
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i
                                        class="icon-copy fa fa-stethoscope"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$yesterday}}</div>
                                <div class="font-14 text-secondary weight-500">Yesterday Collection</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#09cc06">
                                    <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">User Pending and Approve Payment Lists</h4>
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
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ 'JIO-DEP10'.$user->id }}</td>
                                <td>{{ $user->amount }}</td>
                                <td>{{ $user->payment_mode }}</td>
                                <td>{{ $user->date }}</td>
                                <td>
                                    @if ($user->status == 1)
                                        Approved
                                    @elseif ($user->status == 2)
                                        Rejected
                                    @else
                                        Pending
                                    @endif
                            </td>

                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{$data->links('pagination::bootstrap-4')}}
                    </div>
                </div>

            </div>
            @role('super-admin')
                <div class="card-box mb-30">
                    <div class="pd-5 bg bg-light-blue text-center">
                        <h4 class="text-white-heading h3">Ancestor Table</h4>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 m-1">
                        <ul id="user-hierarchy" class="list-group">
                            @if(!empty($childNodes))
                                @foreach($childNodes as $user)
                                    @include('layout.recursive_node', ['user' => $user])
                                @endforeach
                            @endif
                        </ul>
                        <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="sitemap">
                                <h5 class="h5">Your Ancestor</h5>
                                include('layout.recursive_node', ['nodes' => $childNodes])
                            </div>
                        </div> -->
                    </div>
                </div>
            @endrole
        </div>

            

        </div>
    </div>

    <div class="row pb-10">

    </div>
@endsection

@push('js_links')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.toggle-children').on('click', function() {
                $(this).siblings('.child-nodes').toggle();
            });
        });
    </script>
        
@endpush
