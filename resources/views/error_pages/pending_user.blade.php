<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Jio Soul</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script
			async
			src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
		></script>
	</head>
	<body>
		<div
			class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
		>
			<div class="pd-10">
				<div class="error-page-wrap text-center">
					<h1><i class="icon-copy fa fa-check-square-o" aria-hidden="true"></i></h1>
					<p class="text text-center text-success">Hi {{ ucwords(Auth::user()->name) }}, Your registration has been completed successfully. Please wait for admin approval.</p>
					<p>Your Employee ID is : {{Auth::user()->employee_id}} And password is in your MIND </p>
					<p>
						Sorry, access to this resource on the server is denied.</p>
						<p class="text text-center text-danger">Still waiting on administrative approval
					</p>
					<div class="pt-20 mx-auto max-width-200">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
