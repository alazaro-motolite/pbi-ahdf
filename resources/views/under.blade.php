<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name') }} | 503</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
	<style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, Helvetica, sans-serif;
        }
    
        .container {
            width: 100%;
            display: table; 
            table-layout: fixed; 
            height: 1px; 
            position: relative; 
            padding: 20px 20px; 
            min-height: 425px;
        }
    
        .content {
            display: table-row;
        }
    
        .wrapper {
            display: table-cell; 
            vertical-align: top; 
            width: 100%;
        }
    
        .page-content {
            margin-bottom: 20px;
            text-align: center;
        }
    
        .offline-title {
            font-size: 180px; 
            color: #333;  
            line-height: 1; 
            margin: 20px 0 40px; 
            font-weight: 500; 
            text-stroke: 1px transparent; 
            display: block; 
            text-shadow: 0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0, 0, 0, 0.1), 0 0 5px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.3), 0 3px 5px rgba(0, 0, 0, 0.2), 0 5px 10px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.2), 0 20px 20px rgba(0, 0, 0, 0.15);
            letter-spacing: -0.015em;
            text-align: center;
        }
    
        h4 {
            letter-spacing: -0.015em; 
            font-size: 19px; 
            margin: 10px 0px; 
            font-weight: 500; 
            line-height: 1.5384616; 
            color: #333;
            text-align: center;
        }
    
        @media (max-width: 768px) {
            .offline-title {
                font-size: 90px;
            }
        }
        </style>

</head>

<body>
    <div class="container">
    	<div class="content">
        	<div class="wrapper">
                <div class="page-content">
					<h1 class="offline-title">Under Maintenance</h1>
					<h4>Sorry, our website is under maintenance.</h4>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
