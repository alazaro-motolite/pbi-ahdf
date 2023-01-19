<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name') }} | {{  ucfirst(request()->segment(1)) }}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<!--<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script> -->
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/nicescroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/drilldown.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/daterangepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/inputs/duallistbox.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/extensions/session_timeout.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/prism.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/anytime.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/media/fancybox.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/fullcalendar/fullcalendar.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/visualization/echarts/echarts.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/js/core/app.js') }}"></script>
	<script type="text/javascript">
        let webURL = "{!! config('app.url') !!}";
		
        function updateClock ( )
        {
            let today = "{{ date('M j, Y') }}";
            let clientTime = new Date();
            let currentTime = new Date ();
            let timeOffset = 8 * 60 * 60 * 1000;
            currentTime.setTime(clientTime.getTime() + timeOffset);

            let currentHours = currentTime.getUTCHours ( );
            let currentMinutes = currentTime.getUTCMinutes ( );
            let currentSeconds = currentTime.getUTCSeconds ( );
            let currentDay = currentTime.getUTCDay();
            let day = currentTime.getDate();
            let currentMonth = currentTime.getMonth();
            let currentYear = currentTime.getFullYear();

            let dayArr = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
            let monthArr = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

            currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
            currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

            let timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
			
			if(currentHours < 12)
			{
				document.getElementById('ampm').innerHTML = 'Good morning'
			}
			else if(currentHours > 12 && currentHours < 18)
			{
				document.getElementById('ampm').innerHTML = 'Good afternoon'
			}
			else 
			{
				document.getElementById('ampm').innerHTML = 'Good evening'
			}
            currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
            currentHours = ( currentHours == 0 ) ? 12 : currentHours;

            let currentTimeString = today + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            //let currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            document.getElementById("clock").innerHTML = currentTimeString;
        }

        setInterval("updateClock()", 1000); 
    </script>

	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /theme JS files -->
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse bg-indigo-800">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="{{ asset('assets/images/LifeCare-Logo.jpg') }}" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			
			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('assets/images/no_photo.fw.png') }}" alt="">
						<span>{{ Session::get('name') }}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a style="cursor: pointer;" data-url="{{ config('app.url') }}/change-password" data-toggle="modal" data-target="#modal_current_user_change_password"><i class="icon-lock2"></i> Change Password</a></li>
						<li><a href="{{ route('logout') }}"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav navbar-nav-material">
				@if (in_array(Session::get('groupID'), [2, 3, 4]))
				<li {{ (request()->segment(1) == 'dashboard') ? 'class=active' : '' }}>
					<a href="{{ route('dashboard') }}">
						<i class="icon-display4 position-left"></i> Dashboard
					</a>
				</li>
				@endif
				
				@if (Session::get('groupID') == 2)
				<li {{ (request()->segment(1) == 'employee') ? 'class=active' : '' }}>
					<a href="{{ route('employee') }}">
						<i class="icon-users4 position-left"></i> Employee
					</a>
				</li>
				@endif
				@if (Session::get('groupID') == 1)
				<li {{ (request()->segment(1) == 'cms') ? 'class=active dropdown' : 'dropdown' }}>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog position-left"></i> Content Management <span class="caret"></span>
					</a>
					<ul class="dropdown-menu width-250">
						<li class="dropdown-header">Content Management</li>
						<li>
							<a href="{{ route('cms.company') }}" style="font-weight: 500;">
								<i class="icon-office"></i> Company
							</a>
						</li>
						<li>
							<a href="{{ route('cms.checklist') }}" style="font-weight: 500;">
								<i class="icon-list3"></i> Symptoms/Checklist
							</a>
						</li>
						<li>
							<a href="{{ route('cms.entry') }}" style="font-weight: 500;">
								<i class="icon-enter6"></i> Point of Entry
							</a>
						</li>
						<li>
							<a href="{{ route('cms.employee.type') }}" style="font-weight: 500;">
								<i class="icon-users2"></i> Employee Type
							</a>
						</li>
					</ul>
				</li>

				<li {{ (request()->segment(1) == 'user') ? 'class=active' : '' }}>
					<a href="{{ route('user') }}">
						<i class="icon-users position-left"></i> User Management
					</a>
				</li>
				@endif
			</ul>

			<ul class="nav navbar-nav navbar-nav-material navbar-right">
				<li>
					<a>
						<i class="icon-alarm position-left"></i>
						<span id="clock"></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /second navbar -->

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">{{ (request()->segment(1) == 'dashboard') ? 'Home' : ucwords(str_replace('-', ' ', request()->segment(1))) }}</span> - Dashboard
					<small class="display-block"><span id="ampm"></span>, {{ Session::get('name') }}!</small>
				</h4>
			</div>
		</div>
	</div>
	<!-- /page header -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				@yield('contents')

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<!-- New form modal -->
	<div id="modal_current_user_change_password" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Change Password</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelUserChangePassword" data-dismiss="modal"><b><i class="icon-x position-left"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnUserChangePassword"><b><i class=" icon-database-add position-left"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /new form modal -->


	<!-- Footer -->
	<div class="footer text-muted">
		&copy; {{ date('Y') }}. {{ config('app.name') }}. All Rights Reserved.
	</div>
	<!-- /footer -->

</body>
</html>
