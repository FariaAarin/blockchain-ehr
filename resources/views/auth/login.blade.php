<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>EHR</title>
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
	
	<!-- loader-->
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/icons.css')}}" />
	<!-- App CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/app.css')}}" />
</head>

<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="section-authentication-login  align-items-center justify-content-center">
			<div class="row">
				<div class="col-6 col-lg-6 mx-auto">
					<div class="card radius-15">
						
						<div class="card-body p-md-5">
							<div class="text-center">
								<img src="{{asset('assets/images/logo-icon.png')}}" width="80" alt="">
								<h3 class="mt-4 font-weight-bold">EHR</h3>
							</div>
							<ul class="mt-3 list-disc list-inside text-sm text-red-600">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>

							
							@if($errors->any())
								<div class="alert alert-danger">
									<p><strong>Opps Something went wrong</strong></p>
									<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
									</ul>
								</div>
							@endif
							<form action='{{route('login')}}' method="POST" >
							@csrf
							<div class="form-group mt-4">
								<label>Username</label>
								<input type="text" class="form-control" name="email" placeholder="Enter your Username" />
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" name="password" placeholder="Enter your password" />
							</div>
							
							<div class="btn-group mt-3 w-100">
								<button type="submit" class="btn btn-primary btn-block">Log In</button>
								<button type="submit" class="btn btn-primary"><i class="lni lni-arrow-right"></i>
								</button>
							</div>
							</form>
						</div>
							
						<!--end row-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>