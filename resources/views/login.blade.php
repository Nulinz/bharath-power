<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<title>Sign In | AdminKit Demo</title>

  	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">


	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


	<link href="{{ asset('assets/css/light.css') }}" rel="stylesheet">
</head>
<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
	<main class="d-flex w-100 h-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back!</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<img src="{{ asset('assets/images/bp_logo.jpeg') }}" class="mx-auto" height="90" class="barnd" alt="bp_logo">
								</div>
								<div class="m-sm-3">
								@if ($errors->any())
									<div class="alert alert-danger">
											@foreach ($errors->all() as $error)
												<p class="mb-0 fw-bold text-dark p-2">{{ $error }}</p>
											@endforeach
									</div>
									@endif
									<form action="{{ route('logval') }}" method="POST">
                                        @csrf
										<div class="mb-3">
											<label class="form-label">Contact Number</label>
											<input class="form-control form-control-lg" type="text" name="contact_number" placeholder="Enter your Number"  maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
										</div>
										{{-- <div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
										</div> --}}

										<label class="form-label">Password</label>
										<div class="input-group">
											<input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="Enter your Password" required>
											<div class="input-group-text">
												<button type="button" class="btn btn-sm border-0 bg-light btn-toggle-password-visibility">
													<i class="fa fa-eye-slash"></i>
												</button>
											</div>
										</div>

										<div class="d-grid gap-2 mt-3">
                                            <button class='btn btn-lg btn-primary'>Sign in</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
	<script>
		$(document).on('click', '.btn-toggle-password-visibility', function () {
			const $input = $(this).closest('.input-group').find('input.form-control');
			const $icon = $(this).find('i');

			const isPassword = $input.attr('type') === 'password';
			$input.attr('type', isPassword ? 'text' : 'password');

			// Toggle icon class
			$icon.toggleClass('fa-eye');
		});
	</script>
</body>
</html>