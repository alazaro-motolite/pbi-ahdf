<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name') }} - Form</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/extras/animate.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/nicescroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/drilldown.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
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
			
            currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
            currentHours = ( currentHours == 0 ) ? 12 : currentHours;

            let fullCurrentTimeString = today + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            let currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            document.getElementById("clock").innerHTML = fullCurrentTimeString;
            document.getElementById("clock2").innerHTML = fullCurrentTimeString;
        }

        setInterval("updateClock()", 1000); 
    </script>

    <script type="text/javascript" src="{{ asset('assets/js/form.js') }}"></>
    
	<script type="text/javascript" src="{{ asset('assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /theme JS files -->

    @laravelPWA
    
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse" style="background-color: #FFFFFF;">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="{{ asset('assets/images/LifeCare-Logo.jpg') }}" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li>
                    <a data-toggle="collapse" style="color: #333333 !important" class="text-semibold">
                        <i class="icon-alarm"></i><span class="position-right text-size-small" id="clock"></span>
                    </a>
                </li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#" style="color: #333333 !important" class="text-semibold">
						<i class="icon-alarm"></i><span class="position-right text-size-small text" id="clock2"></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Form content -->
                <div class="panel panel-flat border-top-xlg border-top-indigo">
                    <div class="panel-body">
                        <form id="hdForm" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 class="text-semibold text-center" style="margin-top: 0px;">Health Declaration Form</h2>
                                    <div class="alert bg-danger text-white alert-styled-left alert-dismissible" id="messageError" style="display: none">
                                        <span class="font-weight-semibold" id="messageErrorText">Error!</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* SELECT GROUP:</label>
    
                                        <label class="radio-inline text-semibold">
                                            <input type="radio" {{ ($keyword != 'guest' && $keyword != '') ? 'checked=checked'.' disabled=disabled' : '' }} {{ ($keyword == 'guest') ? 'disabled=disabled' : '' }} name="profileGroup" id="profileGroup" value="employee">
                                            EMPLOYEE
                                        </label>
    
                                        <label class="radio-inline text-semibold">
                                            <input type="radio" {{ ($keyword == 'guest') ? 'checked=checked'.' disabled=disabled' : '' }} {{ ($keyword != 'guest' && $keyword != '') ? 'disabled=disabled' : '' }} name="profileGroup" id="profileGroup" value="guest">
                                            GUEST
                                        </label>

                                        <label class="error display-block" id="profileGroupError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select group.</label>
                                    </div>

                                    <div class="form-group input-emp-no">
                                        <label class="display-block text-semibold">* EMPLOYEE NUMBER :</label>
                                        <span class="help-block">e.g. 10006890</span>
                                        <input type="text" id="empNum" name="empNum" maxlength="8" value="{{ $keyword }}" class="form-control" placeholder="You answer">
                                        <label class="error" id="empNumError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Employee number is required.</label>
                                    </div>

                                    <div class="form-group input-guest-no">
                                        <label class="display-block text-semibold">GUEST NUMBER :</label>
                                        <span class="help-block">If you have submitted a declaration as Guest before, a Guest Number has been created for you. Try to key in the following: [Your birthday] + [Your initials: First+Middle+Last] in the format MMDDYYYFML. E.g. 01011990JCD. If an error appears, kindly proceed in filling out the rest of the form instead.</span>
                                        <input type="text" id="guestNum" name="guestNum" value="" class="form-control" placeholder="You answer">
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* LAST NAME (APELYIDO) :</label>
                                        <input type="text" id="lastName" name="lastName" class="form-control" placeholder="You answer" >
                                        <label class="error" id="lastNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Last name is required.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* FIRST NAME (PANGALAN) :</label>
                                        <input type="text" id="firstName" name="firstName" class="form-control" placeholder="You answer">
                                        <label class="error" id="firstNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* First name is required.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* MIDDLE NAME (GITNANG PANGALAN) :</label>
                                        <input type="text" id="midName" name="midName" class="form-control" placeholder="You answer">
                                        <label class="error" id="midNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Middle name is required.</label>
                                    </div>

                                    <div class="form-group input-bday">
                                        <label class="display-block text-semibold">* BIRTHDAY (PETSA NG KAARAWAN) :</label>
                                        <span class="help-block">Birthday format: MM-DD-YYYY (e.g.,12-25-2021)</span>
                                        <input type="text" id="birthDate" name="birthDate" class="form-control" placeholder="Your answer">
                                        <label class="error" id="birthDateError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Birth date is required.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* COMPANY NAME (KOMPANYA) :</label>
                                        <span class="help-block" id="help-text" style="display: none;">Please write NA if not applicable.</span>
                                        <select class="form-control" id="optCompany" name="optCompany">
                                            <option value="">SELECT ONE</option>
                                            @foreach ($company as $row)
                                            <option value="{{ strtoupper($row->company) }}">{{ strtoupper($row->company) }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="inpCompany" name="inpCompany" style="display: none;" class="form-control" placeholder="Your answer">
                                        <label class="error" id="companyError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select company.</label>
                                    </div>
    
                                    <div class="form-group input-address">
                                        <label class="display-block text-semibold">* COMPLETE ADDRESS (TIRAHAN) :</label>
                                        <span class="help-block">House #/Lot/Bldg, Street/Brgy./Municipality/City</span>
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Your answer">
                                        <label class="error" id="addressError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Address is required.</label>
                                    </div>

                                    <div class="form-group input-mobile">
                                        <label class="display-block text-semibold">* MY CELLPHONE NUMBER (SARILI KONG CELLPHONE #) :</label>
										<span class="help-block">Cellphone No. format: 09991234567</span>
                                        <input type="text" id="mobileNo" name="mobileNo" maxlength="11" class="form-control" placeholder="Your answer">
                                        <label class="error" id="mobileNoError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Cellphone number is required.</label>
                                    </div>

                                    <div class="form-group input-guest-email">
                                        <label class="display-block text-semibold">EMAIL ADDRESS :</label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="You answer">
                                        <label class="error" id="emailError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Invalid email address.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* POINT OF ENTRY (LUGAR NA PUPUNTAHAN) :</label>
                                        <span class="help-block" id="help-text" style="display: none;">Please write NA if not applicable.</span>
                                        <select class="form-control" id="optEntryPoint" name="optEntryPoint">
                                            <option value="">SELECT ONE</option>
                                            @foreach ($entryPoint as $item)
                                            <option value="{{ $item->id }}">{{ strtoupper($item->entry_point) }}</option>
                                            @endforeach
                                        </select>
                                        <label class="error" id="optEntryPointError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select point of entry.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">* LAST PLACE VISITED (HULING LUGAR NA BINISITA):</label>
                                        <input type="text" id="lastVisit" name="lastVisit" class="form-control" placeholder="You answer">
                                        <label class="error" id="lastVisitError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Enter the last place you visit.</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="display-block text-semibold">In the last 14 days, have you been in close contact or exposed to any person suspected of COVID-19? (Sa nakalipas na 14 na araw, Ikaw ba ay may nakahalubilo o nalantad sa sinumang taong pinaghihinalaang may COVID-19?)</label>
                                        <label class="radio-inline text-semibold">
                                            <input type="radio" name="isExpose" id="isExpose" value="Yes">
                                            YES
                                        </label>
    
                                        <label class="radio-inline text-semibold">
                                            <input type="radio"name="isExpose" id="isExpose" value="No">
                                            NO
                                        </label>
                                        <label class="error display-block" id="exposedError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select Yes or No.</label>
                                    </div>

                                </div>    

                                <div class="col-md-7 col-md-offset-1">
                                    <h2 class="text-center text-semibold" style="margin-top: 0px;">COVID-19 PREVENTION</h2>
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/covid_img.png') }}" class="content-group" style="max-width: 100%; height: auto;">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label style="font-weight: 500;">
                                                        <input type="radio" name="confirmation" id="confirmation" value="No">
                                                        I am NOT FEELING ANY SYMPTOMS. (Ako ay WALANG NARARAMDAMANG SINTOMAS.)
                                                    </label>
                                                </div>

                                                <div class="radio">
                                                    <label style="font-weight: 500;">
                                                        <input type="radio" name="confirmation" id="confirmation" value="Yes">
                                                        I am FEELING AT LEAST ONE OF THE SYMPTOMS listed below. (Ako ay MAY NARARAMDAMANG ISA O HIGIT PA SA MGA SINTOMAS na nakalista sa ibaba.)
                                                    </label>
                                                </div>

                                                <label class="error" id="confirmationError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select if you have symptoms or not.</label>
                                            </div>

                                            <h4>Symptoms Checklist</h4>
                                            <label class="error display-block" id="checklistError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* One(1) or more checklist is/are not checked.</label>
                                            <table class="table table-sm">
                                                <tbody>
                                                @foreach ($checklist as $item)
                                                    <tr class="form-group">
                                                        <td class="col-md-10 text-semibold" style="padding: 8px;">{{ $item->checklist }}</td>
                                                        <td class="text-center col-md-1" style="padding: 8px;">
                                                            <label class="radio-inline text-semibold">
                                                                <input type="radio" name="answer_{{ $item->id }}" id="answer_{{ $item->id }}_Yes" value="Yes">
                                                                YES
                                                            </label>
                                                        </td>
                                                        <td class="text-center col-md-1" style="padding: 8px;">
                                                            <label class="radio-inline text-semibold">
                                                                <input type="radio" name="answer_{{ $item->id }}" id="answer_{{ $item->id }}_No" value="No">
                                                                NO
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <h4>DECLARATION AND DATA PRIVACY CONSENT</h4>
                                            <div class="form-group">
                                                <label class="display-block">All the information I have provided is factual. I give LifeCare permission to provide a copy to my employers or the company I am visiting, and its authorized personnel. LifeCare has no legal responsibility for this document. I understand that all information I have provided is protected by RA 10173, Data Privacy Act of 2012 and I am required to provide true information in accordance with RA 11469, Bayanihan to Heal as One Act. </label>
                                                <label class="display-block" style="margin-top: 10px">(Lahat ng impormasyong aking ibinigay ay pawang katotohanan lamang. Binibigyan ko ng pahintulot ang LifeCare na bigyan ng kopya ang aking employers o ang binibisita kong kumpanya, at otorisadong tao nito. Walang legal na responsibilidad ang LifeCare sa dokumentong ito. Aking naiintindihan na lahat ng impormasyong aking ibinigay ay protektado ng RA 10173, Data Privacy Act of 2012 at ako ay kinakailangang magbigay ng totoong impormasyon naaayon sa RA 11469, Bayanihan to Heal as One Act.)</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-inline text-semibold">
                                                    <input type="checkbox" class="styled" name="chkPrivacy" id="chkPrivacy">
                                                    DECLARATION AND DATA PRIVACY CONSENT
                                                </label>
                                                <label class="error display-block" id="chkPrivacyError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please check Declaration and Data Privacy.</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="text-right">
                                        <input type="hidden" id="refNum" value="{{ $referenceNo }}">
                                        <input type="hidden" id="cIDs" value="{{ $ids }}">
                                        <input type="hidden" id="newRegistration">
                                        <input type="hidden" id="isExist">
                                        <input type="hidden" id="url" value="{{ config('app.url') }}">
                                        <button type="button" id="btnSave" data-url="{{ config('app.url') }}/save" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-database-add"></i></b> Submit form</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
                <!-- /form content -->
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<!-- Footer -->
	<div class="footer text-muted">
		&copy; {{ date('Y') }} {{ config('app.name') }} Form. All Rights Reserved.
	</div>
	<!-- /footer -->

</body>
</html>
