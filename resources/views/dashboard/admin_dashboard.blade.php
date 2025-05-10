@extends('layout.default')

@section('title', 'Dashboard')

@section('content')

    <div class="title pb-20">
        <h2 class="h3 mb-0">Jio Overview</h2>

        <div class="min-height-200px" id="content">
        <!-- Default Basic Forms Start -->
                <h4 class="text text-success">Approved Payment</h4>
            <hr/>
            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$users}}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Total Depositors
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#00eccf">
                                    <i class="icon-copy fa fa-user-circle-o" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <!-- 2nd Row -->
            <div class="min-height-200px" id="content">
                    <h4 class="text text-warning">Pending Payment</h4>
                <hr/>
            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{$totalPendingColllection}} + </div>
                                <div class="font-14 text-secondary weight-500">
                                    Total Pending
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
                                <div class="weight-700 font-24 text-dark">{{$todayPending}}+</div>
                                <div class="font-14 text-secondary weight-500">
                                    Today Pending
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
                                <div class="weight-700 font-24 text-dark">{{$yesterdayPending}}</div>
                                <div class="font-14 text-secondary weight-500">Yesterday Pending</div>
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

            <!-- <div class="row pb-10">
                <div class="col-md-12 mb-20">
                    <div class="card-box height-100-p pd-20">
                        <div
                            class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3"
                        >
                            <div class="h5 mb-md-0">Jio Activities</div>
                            <div class="form-group mb-md-0">
                                <select class="form-control form-control-sm selectpicker">
                                    <option value="">Last Week</option>
                                    <option value="">Last Month</option>
                                    <option value="">Last 6 Month</option>
                                    <option value="">Last 1 year</option>
                                </select>
                            </div>
                        </div>
                        <div id="activities-chart"></div>
                    </div>
                </div>
                <div class="col-md-4 mb-20">
                    
                </div>
            </div> -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-20">
                        <div class="card-box height-100-p pd-20 min-height-200px">
                            <div class="d-flex justify-content-between pb-10">
                                <div class="h5 mb-0">Top Depositor</div>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        data-color="#1b3133"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown"
                                    >
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <!-- <div
                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
                                    >
                                        <a class="dropdown-item" href="#"
                                            ><i class="dw dw-eye"></i> View</a
                                        >
                                        <a class="dropdown-item" href="#"
                                            ><i class="dw dw-edit2"></i> Edit</a
                                        >
                                        <a class="dropdown-item" href="#"
                                            ><i class="dw dw-delete-3"></i> Delete</a
                                        >
                                    </div> -->
                                </div>
                            </div>
                            <div class="user-list">
                                <ul>
                                    @foreach($topDepositors as $num => $depositor)
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="name-avatar d-flex align-items-center pr-2">
                                            <div class="avatar mr-2 flex-shrink-0">
                                                <img
                                                    src="vendors/images/photo1.jpg"
                                                    class="border-radius-100 box-shadow"
                                                    width="50"
                                                    height="50"
                                                    alt=""
                                                />
                                            </div>
                                            <div class="txt">
                                                <span
                                                    class="badge badge-pill badge-sm"
                                                    data-bgcolor="#e7ebf5"
                                                    data-color="#265ed7"
                                                    >{{++$num}}</span
                                                >
                                                <div class="font-14 weight-600">{{ucwords($depositor->name)}}</div>
                                                <div class="font-12 weight-500" data-color="#b2b1b6">
                                                    Pediatrician
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cta flex-shrink-0">
                                            <a href="#" class="btn btn-sm btn-outline-primary"
                                                >{{$depositor->total_amount}} ₹</a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-6 mb-20">
                        <div
                            class="card-box min-height-200px pd-20 mb-20"
                            data-bgcolor="#E6A4B4"
                        >
                            <div class="d-flex justify-content-between pb-20 text-white">
                                <div class="icon h1 text-white">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i>
                                </div>
                                <div class="font-14 text-right">
                                    <div><i class="icon-copy ion-arrow-up-c"></i> 2.69%</div>
                                    <div class="font-12">Since last month</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="text-white">
                                    <div class="font-14">Approve Payment</div>
                                    <div class="font-24 weight-500">1865</div>
                                </div>
                                <div class="max-width-150">
                                    <div id="appointment-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box min-height-200px pd-20" data-bgcolor="#265ed7">
                            <div class="d-flex justify-content-between pb-20 text-white">
                                <div class="icon h1 text-white">
                                    <i class="fa fa-stethoscope" aria-hidden="true"></i>
                                </div>
                                <div class="font-14 text-right">
                                    <div><i class="icon-copy ion-arrow-down-c"></i> 3.69%</div>
                                    <div class="font-12">Since last month</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="text-white">
                                    <div class="font-14">Surgery</div>
                                    <div class="font-24 weight-500">250</div>
                                </div>
                                <div class="max-width-150">
                                    <div id="surgery-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
