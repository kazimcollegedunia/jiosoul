@extends('layout.default')

@section('title', '500')

@section('content')
<div
	class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
>
	<div class="pd-10">
		<div class="error-page-wrap text-center">
			<h1>500</h1>
			<h3>Error: 500 Internal Server Error</h3>
			<p>
				Sorry, the server is currently experiencing technical difficulties.<br />
				Please leave a message to  Tech Team
			</p>
			<div class="pt-20 mx-auto max-width-200">
				<a href="{{ route('dashBoard') }}" class="btn btn-primary btn-block btn-lg"
					>Back To Home</a
				>
			</div>
		</div>
	</div>
</div>
@endsection