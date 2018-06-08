@php
	use App\Producto;
	$producto_mod = App\Producto::find($producto);
@endphp

@extends('master')

@section('title', 'detalle')

@section('content')

	<style type="text/css">
	.card-header{
		background-color: #a9c8cf;
		color: #fff;
	}
	.breadcrumb{
		background-color: #a9c8cf;
    	border: 1px solid #559dae;

		color: #fff;
	}
	
	.breadcrumb li a{
		color: #fff;
	}

	.breadcrumb > .active {
    	color: #17396b;
	}
	.breadcrumb > li + li::before {
	    color: #edecec;
	}

	.carousel-indicators li{
		background-color: #86a4d1;
		box-shadow: 0px 0px 10px 1px #506789;
	}

	.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #559dae;
    border-radius: 8px;
}

.card-header:first-child {
    border-radius: 8px 8px 0 0;
}
.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    border-bottom: 1px solid #559dae;
    
}

.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}

.card-footer:last-child {
    border-radius: 0 0 calc(.25rem - 1px) calc(.25rem - 1px);
}
.card-footer {
    padding: .75rem 1.25rem;
    background-color: rgba(0,0,0,.03);
    border-top: 1px solid rgba(0,0,0,.125);
}
	</style>

	<!-- Detalles e imagenes -->
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb" style="padding: 12px; font-size: 18px;">
				<li class=""><a href="#">Productos</a></li>
				<li class=""><a href="#">{{$producto_mod->categoria()->first()->nombre}}</a></li>
				<li class=" active">{{$producto_mod->nombre}}</li>
			</ol>
		</div>

		<div class="col-md-12">

			<div class="card" >
				
				<div class="col-md-12 text-right card-header" style="font-size: 25px;">
					{{$producto_mod->nombre}}
				</div>
				<div class="col-md-12 card-body">
						<div class="col-md-6">
							@php
							$imagenes = $producto_mod->imagenes()->get();
							/*
								$images[0] = "img/cool1.jpg";
								$images[1] = "img/Back01.jpg";
								$images[2] = "img/cool1.jpg";
								$images[3] = "img/Back01.jpg";
							*/
								//echo $imagenes;
							@endphp

							<div id="myCarousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
							  	@for ($i = 0; $i < $imagenes->count(); $i++)
								  	@if($i == 0)
										<li class="active" data-target="#myCarousel" data-slide-to="{{$i}}"></li>
								  		
								  	@else
										<li data-target="#myCarousel" data-slide-to="{{$i}}"></li>

								  	@endif
								@endfor
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner" style="height: 320px;" role="listbox">

								@foreach ($imagenes as $imgs)
								  	@if($loop->first)
										<div class="item carousel-item text-center active" style="height: 100%"">
								  	@else
										<div class="item carousel-item text-center " style="height: 100%;"">
								  	@endif
										<img class="item-img-carousel img-" style=" margin: auto; max-height: 100%; max-width: 100%;" src="http://localhost:8000/{{$imgs->img_url }}" alt="">
									</div>
								@endforeach
							</div>

							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel" data-slide="prev" role="button">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" data-slide="next" role="button">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Next</span>
							</a>
							</div>
							<script type="text/javascript">
							</script>
						</div>

						<div class="col-md-6">
							
						</div>
				
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