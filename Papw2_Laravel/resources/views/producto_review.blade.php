@php
	use App\Producto;
	use App\User;
	use App\Comentario;

	use Carbon\Carbon;

	Carbon::setLocale('es');

	$producto_mod = $producto;
	$comentarios = $producto_mod->comentarios()->orderBy('created_at', 'desc');
	$aComentado = false;
	
	
	$ranking = -1; 
	if($comentarios->count() != 0){
		$ranking = $comentarios->sum('ranking') / $comentarios->count();
		$ranking = floor($ranking);
	}

	if(Auth::check()){
		if(Auth::user()->esAdmin()  || Auth::user()->id == $producto_mod->id_usuario ){
			$comentarios = $comentarios->withTrashed();
		}
	}

	$comentarios = $comentarios->get();
	$usuarioProducto = App\User::find($producto_mod->usuario()->first()->id);

	/*$producto_mod->created_at = Carbon::now();
	$producto_mod->save();*/

@endphp

@extends('master')

@section('title', 'Revision')

@section('content')

@push('styles')
    <link href="{{asset('css/producto.css')}}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
@endpush
	
	<!-- Producto -->

	<div class="row">
		
		<!-- Bread -->
		<div class="col-md-12">
			<ol class="breadcrumb" style="padding: 12px; font-size: 18px;">
				<li class=""><a href="{{route('busqueda')}}">Productos</a></li>
				<li class=""><a href="{{route('busqueda').'?categoria='.$producto_mod->categoria()->first()->id}}">{{$producto_mod->categoria()->first()->nombre}}</a></li>
				<li class=" active">{{$producto_mod->nombre}}</li>
			</ol>
		</div>

		<!-- Descripcion Producto -->
		<div class="col-md-12">
			<div class="card" >
				<div class="col-md-12 text-right card-header" style="font-size: 25px;">
					<div class="ranking-header">
						@if($ranking != -1)
							@for ($i = 0; $i < 5; $i++)
								@if($i < $ranking)
									<span class="glyphicon glyphicon-star "></span>
								@else
									<span class="glyphicon glyphicon-star-empty"></span>
								@endif
							@endfor
						@else
							@for ($i = 0; $i < 5; $i++)
								<span class="glyphicon glyphicon-star text-muted"></span>
							@endfor
						@endif
					</div>
					{{$producto_mod->nombre}}
				</div>
				<div class="col-md-12 card-body">
						<div class="col-md-7">
							@php
								$imagenes = $producto_mod->imagenes()->get();
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
							<div class="carousel-inner" style="height: 420px;" role="listbox">

								@foreach ($imagenes as $imgs)
								<div class="item carousel-item text-center 	@if($loop->first) active @endif" >
									<img class="item-img-carousel img-" src="{{URL::to('/') .'/'. $imgs->img_url }}">
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
						<!--End of carousel -->

						<div class="col-md-5 desc-cont">
							<div class="div-descripcion">	
								<div class="desc-header">
									<div class="text-left descripcion-precio">{{'$' . $producto_mod->precio}}</div>	
									<div class="datos-vendedor">
										<div class="descripcion-nombre"><span class="highlight">Creado por: </span>
											<a href="{{route('perfil').'/'.$usuarioProducto->id }}">{{$usuarioProducto->name}}</a>
										</div>
										<div class="descripcion-avatar">
											<a href="{{route('perfil').'/'.$usuarioProducto->id }}">
												<img class="img-responsive img-thumbnail" src="{{URL::to('/') . '/' .$usuarioProducto->imagen()}}">
											</a>
										</div>
									</div>		
								</div>
								<div class="text-left descripcion-corta-producto">{{$producto_mod->desc_corta}}</div>
								<form role="form" class="form-body" method="POST" action="/">
					     			<input type="number" name="producto" hidden value="{{$producto_mod->id}}" required style="display: none;">

							     	<div class="form-group">
							     		<div class="col-xs-6">
									    	<label class="control-label label-form float-left" for="cantidad">Cantidad</label>
							     			<input type="number" name="cantidad" class="form-control" id="cantidad" value="1" required min="1">
										</div>
							     		<div class="col-xs-6">
								  			<button id="btnComprar" type="button"  class="btn btn-default" data-toggle="modal" data-target="#myModal">Comprar</button>
							     		</div>
									</div>
								</form>
								
							</div>
						</div>
					<div class="col-md-12">
					
					</div>
				</div>
				<div class="detalles">
					<p><span class="highlight">Detalles: </span></p>
					<p>{{$producto_mod->detalles}}</p>
				</div>
				<div class="col-md-12 card-footer">
					<div class="text-muted time-info-producto">
						{{$producto_mod->created_at }} <span class="glyphicon glyphicon-calendar"></span>
					</div>
				</div>
			</div>
		</div>

	</div>


	<!-- Agregar Comentario -->
	<div class="row comentario-container" id="make-review">
		<div class="col-md-12">
			<div class="card">
				<div class="col-md-8 col-md-offset-2">
					<div class="mensaje-review">
						<p>Rechaza o Valida el siguiente producto</p>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<form role="form" action="{{route('rechazarProductoReview', $producto_mod->id)}}" class="form-body review-producto" method="POST">
						{{csrf_field()}}
						<input type="hidden" name="_method" value="put" />
						<div>
							<button type="submit" class="btn btn-default" style="width: 100%;">Rechazar</button>
						</div>
					</form>
					<form role="form" action="{{route('validarProductoReview', $producto_mod->id)}}" class="form-body review-producto" method="POST">
						{{csrf_field()}}
						<input type="hidden" name="_method" value="put" />						
						<div>
							<button type="submit" class="btn btn-default" style="width: 100%;">Validar</button>
						</div>
					</form>
				</div>

			</div>
		</div>
		
	</div>

	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body" style="text-align: center;">
	        <p>Producto en revision!!</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>

	  </div>
	</div>

@endsection