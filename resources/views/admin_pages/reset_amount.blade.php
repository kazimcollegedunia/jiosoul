@extends('layout.default')

@section('title', 'Amount Reset Dashboard')

@section('content')

    <div class="title pb-20">
        <h2 class="h3 mb-0">User Amount Reset Dashboard</h2>

        <div class="min-height-200px" id="content">
        <!-- Default Basic Forms Start -->
            <div class="card-box mb-30">
                <div class="pd-5 bg bg-light-blue text-center">
                    <h4 class="text-white-heading h3">User Amount Reset</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                 <p class="text text-danger m-1" title="
                    ⚠ महत्वपूर्ण सूचना:
                    एक बार राशि को रीसेट कर देने के बाद, केवल सुपर एडमिन ही उसे पुनः स्थापित या संशोधित कर सकते हैं। कृपया यह क्रिया सोच-समझकर करें, क्योंकि यह कार्य बिना प्रशासनिक अनुमति के वापस नहीं लिया जा सकता।
                 ">
                 ⚠ Important Notice: Once the amount has been reset, only the Super Admin will have the authority to restore or modify it. Please proceed with caution and ensure that this action is absolutely necessary, as it may not be reversible without administrative intervention*.
                 </p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Mode</th>                            
                            <th>Reset Status</th>                            
                            <th>Submit Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($amountsDataArr as $key => $value)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $value->amount}}</td>
                                <td>{{ $value->status ? "Approve" : 'Rejecteds'}}</td>
                                <td>{{ $value->payment_mode}}</td>
                                <td>{{ $value->reset_amount ? 'Reseted': 'Not reset'}}</td>
                                <td>{{ $value->date}}</td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    @if(isset($amountsDataArr[0]))
                        <a href="{{ route('user.reset.amount.action', [$user_id]) }}"
                            class="btn btn-success m-1"
                            onclick="return confirm('क्या आप वाकई राशि रीसेट करना चाहते हैं? यह कार्य केवल सुपर एडमिन द्वारा बदला जा सकता है।');">
                            Reset Amount
                        </a>
                    @endif
                    <!-- <a href="{{route('user.reset.amount.action',[$user_id])}}" class="btn btn-success m-1">Reset Amount</a> -->
                    
                    <!-- <div class="d-flex justify-content-center">
                        {{-- $users->links('pagination::bootstrap-4') --}}
                    </div> -->
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
