<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name') }} | Login Page</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/nicescroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/drilldown.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script type="text/javascript">
        let webURL = "{!! config('app.url') !!}";
    </script>

	<script type="text/javascript" src="{{ asset('assets/js/core/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/auth.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Form with validation -->
				<form method="POST" id="loginForm">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
							<h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
						</div>

						<div class="alert bg-danger text-white alert-styled-left alert-dismissible" id="loginError" style="display: none">
							<span class="font-weight-semibold" id="loginErrorText">Error!</span>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="Email Address" name="email" id="email">
							<div class="form-control-feedback">
								<i class="icon-envelop text-muted"></i>
							</div>
							<label class="error" id="emailError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display:none; ">* Email address is required.</label>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Password" name="password" id="password">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
							<label class="error" id="passwordError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display:none; ">* Password is required.</label>
						</div>

						<div class="form-group">
							<button type="button" id="btnLogin" class="btn bg-indigo-800 btn-block btn-labeled btn-labeled-right" data-url="{{ config('app.url') }}">
								<b><i class="icon-key"></i></b> Log in
							</button>
						</div>

						<span class="help-block text-center no-margin">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
                        </span>
					</div>
				</form>
				<!-- /form with validation -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
