<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
</head>
<body>
    
    <div style="display: table; table-layout: fixed; position: relative; vertical-align: top; width: 100%; margin: 0 auto; max-width: 360px; height: auto">
        <div style="text-align: center;">
            <img src="{{ asset('assets/images/LifeCare-Logo.jpg') }}" style="margin: 20px 0px; width: 100%; max-width: 250px; height: auto;">
        </div>
        <p style="font-family: 'Poppins', Arial, Helvetica, sans-serif; font-size: 13px; font-weight: 500; word-wrap: normal; text-align: justify; text-justify: inter-word;">
            Dear Guest,<br/><br/>

            Good day! Welcome to Sta. Maria Industrial Park.<br/><br/>

            We have created a Guest Number for you that you can use when accomplishing the Health Declaration Form in case you will be visiting us again. Please see your Guest Number below:<br/>
        </p>
        
        <h3 style="font-family: 'Poppins', Arial, Helvetica, sans-serif; word-wrap: normal; text-align: center; text-justify: inter-word;"><b>{{ $details['guestNo'] }}</b></h3>
		<p style="font-family: 'Poppins', Arial, Helvetica, sans-serif; font-size: 13px; font-weight: 500; word-wrap: normal; text-align: justify; text-justify: inter-word;">
            Alternatively, you may scan the QR code below on your next visit, to fill out the Health Declaration Form. Please note that you should fill out the form on the actual date of your entry.
        </p><br/>
        <div style="text-align: center;">
            <img src="{{ asset('codes/qr_code.png') }}" style="margin: auto; width: 100%; max-width: 200px; height: auto; text-align:center"> <br/><br/>
        </div><br/>
        
        <p style="font-family: 'Poppins', Arial, Helvetica, sans-serif; font-size: 13px; font-weight: 500; word-wrap: normal; text-align: justify; text-justify: inter-word;">
            Thank you!
        </p>
    </div>
    
</body>
</html>