@extends('master')

@section('title', 'detalle')

@section('content')
	<!-- Detalles e imagenes -->
	<div class="row">
		<div class="col-md-12">
			<div style="padding: 25px; font-size: 25px;">
				<i class="fa fa-angle-right "><p> Productos/<a>Categoria</a>/<a>MyProducto</a></p></i>
			</div>
		</div>
			<div class="col-md-6">
				<div>
					<div class="col-md-12">
						<div  style="max-height: 350px; " >
					    	<img class="img-responsive item-img-carousel" src="http://localhost:8000/img/Back01.jpg" alt="">
							
						</div>
					</div>
					<div class="col-md-12">
						@php
						$images = array();
						$images[0] = "img/cool1.jpg";
						$images[1] = "img/cool1.jpg";
						$images[2] = "img/cool1.jpg";
						$images[3] = "img/cool1.jpg";
						@endphp

						<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
						  	@for ($i = 0; $i < count($images); $i++)
							<li data-target="#myCarousel" data-slide-to="{{$i}}"></li>
						@endfor
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner" style="height: 120px">
						@for ($i = 0; $i < count($images); $i++)
						<div class="carousel-item">
						  <img class="item-img-carousel img-responsive" style="width: 100%" src="http://localhost:8000/img/Back01.jpg" alt="">
						</div>
						@endfor
						@foreach($images as $image)
							
						@endforeach
						</div>
						<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Next</span>
						</a>
						</div>
						<script type="text/javascript">
						$('.carousel-inner .carousel-item').first().addClass('active');
						$('.carousel-indicatorsr li').first().addClass('active');

						</script>
					</div>
			
				</div>	
			</div>


		<div class="col-md-9">
			
		</div>

	</div>


	<!-- Detalles Producto -->
	<div class="row">
		
		
	</div>

	<!-- Reseñas Producto -->
	<div class="row">
		
		
	</div>
@endsection