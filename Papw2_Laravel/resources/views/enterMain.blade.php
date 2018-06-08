<!DOCTYPE html>
<html>
<head>
<title>Trinkets And Baubles</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('css/Supernice.css')}}" rel="stylesheet">


    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>


    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">

    <style type="text/css">
    
    

    </style>
</head>
<body style="background-color: #f3f3f3">

	<section id="loginform" class="outer-wrapper">
		<div class="inner-wrapper">
			<div class="container-fluid">
		  		<div class="row" style="text-align:center; margin-top: 20px;">
				    <div style="display: inline-block; width: 350px; text-align:left;" >
				      	<h2 class="text-center"  style="margin-bottom: 20px; "> 
				      		<a  href="/">
					      		<svg class="svg-brand" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					                     width="120px" height="60px" viewBox="0 0 120 60" enable-background="new 0 0 120 60" xml:space="preserve">
					                      <g class="brand-logo">
					                        <text transform="matrix(1 0 0 1 18.1826 40.0684)" font-family="'Berkshire Swash'" font-size="48">T</text>
					                        <text transform="matrix(1 0 0 1 47.2559 40.0684)" font-family="'Berkshire Swash'" font-size="24">&amp;</text>
					                        <text transform="matrix(1 0 0 1 60.8086 40.0684)" font-family="'Berkshire Swash'" font-size="48">B</text>
					                      </g>
					                      <text class="brand-text" transform="matrix(1 0 0 1 3.3203 55)" font-family="'Berkshire Swash'" font-size="14">Trinkets &amp; Baubles</text>
			                  	</svg>
		                  	</a>
		             	</h2>
		      		  	@yield('form')

	    			</div>
	    			<div class="row" style="text-align:center; margin-top: 20px;">
				    <div style="display: inline-block; width: 350px; text-align:left;" >

			      		<div class="no-registrado-body">
		      				@yield('footer')						
						</div>
	    			</div>
			  	</div>
			</div>
		</div>

	</section>
 
</body>
</html>