@extends('layout.default')

@section('title', '404')

@section('content')
<div
	class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
>
	<div class="pd-10">
		<div class="error-page-wrap text-center">
			<h1>403</h1>
			<h3>Error: 403 Forbidden</h3>
			<p>
				THIS AREA IS FORBIDDEN. TURN BACK NOW! <br />Either
				check the URL
			</p>
			<div class="pt-20 mx-auto max-width-200">
				<a href="index.html" class="btn btn-primary btn-block btn-lg"
					>Back To Home</a
				>
			</div>
		</div>
	</div>
</div>
@endsection