@php
	use App\Producto;
	use App\User;
	use App\Comentario;
	use App\CarritoDetalle;

	use Carbon\Carbon;

	$itemsCarrito = App\CarritoDetalle::where('id_usuario', Auth::user()->id)->get();

	$usuario = Auth::user();
	$es_editable = true;
@endphp

@extends('master')

@section('title', 'Dashboard')

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
	
	<!-- Carrito -->

	<div class="row">
		<!-- Bread -->
		<div class="col-md-12">
			<ol class="breadcrumb" style="padding: 12px; font-size: 18px;">
				<li class=""><a href="#">Dashboard Venta</a></li>
				<li class=" active">{{ $usuario->name }}</li>
			</ol>
		</div>

		<!-- Descripcion Producto -->
		

	
		@php
			$productos = $usuario->productos()->where('valid', 1)->take(5)->get();
		@endphp

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<div class="col-xs-12">
						<div class="col-sm-4 col-lg-3 col-md-3">
						    <div class="thumbnail crear-producto">
						        <a href="{{route('verCrearProducto')}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
						        	<span class="agregar-simbolo glyphicon glyphicon-plus"></span>
						        	<span class="texto-crear">Crear Producto</span>
						        </a>   
						    </div>
						</div>

						@foreach($productos as $producto)
						@php
							$producto = App\Producto::find($producto->id);
							$img = $producto->imagenes()->first();

							$comentarios = $producto->comentarios();
							$ranking = -1; 
                            $ranking = $producto->ranking;
							/*
							if($comentarios->count() != 0){
								$ranking = $comentarios->sum('ranking') / $comentarios->count();
							}*/

						@endphp
						<div class="col-sm-4 col-lg-3 col-md-3">
						    <div class="thumbnail">
						        <a href="{{route('producto', $producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
						        </a>      
						        <div  style="overflow-y: hidden; height: 120px;">
						            <img src="{{URL::to('/') . '/' . $img->img_url}}" alt="" class="img-responsive">
						        </div>
						        <div class="caption">
						            <h4 class="">${{$producto->precio}} MX</h4>
						            <h4><a href="#">{{$producto->nombre}}</a></h4>
						            <p>{{$producto->desc_corta}}</p>
						        </div>
						        <div class="ratings">
						            <p>
					            	@for ($i = 0; $i < 5; $i++)
										@if($i < $ranking)
											<span class="glyphicon glyphicon-star "></span>
										@else
											<span class="glyphicon glyphicon-star-empty"></span>
										@endif
									@endfor

						            </p>
						        </div>
						    </div>
						</div>
						@endforeach
					</div>
					<div class="col-md-12">
						<a href="{{route('busqueda').'?vendedorId='.$usuario->id}}" type="button" class="btn btn-info btn-lg"  style="width: 100%">Ver todos mis productos.</a>
					</div>
				</div>
			</div>
		</div>

		

		@php
			$productos = $usuario->productos()->where('valid', 0)->where('on_review', 0)->take(6)->get();
		@endphp

		@if($productos->count() > 0)

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-header">
					Productos en edicion
				</div>
				<div class="col-md-12 card-body">
					<div class="col-xs-12">
						
						@foreach($productos as $producto)
						@php
							$producto = App\Producto::find($producto->id);
							$img = $producto->imagenes()->first();

							$comentarios = $producto->comentarios();
							$ranking = -1; 
                            $ranking = $producto->ranking;
							/*
							if($comentarios->count() != 0){
								$ranking = $comentarios->sum('ranking') / $comentarios->count();
							}*/

						@endphp
						<div class="col-sm-4 col-lg-3 col-md-3">
						    <div class="thumbnail">
						        <a href="{{route('verEdicionProducto', $producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
						        </a>      
						        <div  style="overflow-y: hidden; height: 120px;">
						            <img src="{{URL::to('/') . '/' . $img->img_url}}" alt="" class="img-responsive">
						        </div>
						        <div class="caption">
						            <h4 class="">${{$producto->precio}} MX</h4>
						            <h4><a href="#">{{$producto->nombre}}</a></h4>
						            <p>{{$producto->desc_corta}}</p>
						        </div>
						        <div class="ratings">
						            <p>
					            	@for ($i = 0; $i < 5; $i++)
										@if($i < $ranking)
											<span class="glyphicon glyphicon-star "></span>
										@else
											<span class="glyphicon glyphicon-star-empty"></span>
										@endif
									@endfor

						            </p>
						        </div>
						    </div>
						</div>
						@endforeach
					</div>
					<div class="col-md-12">
						<a href="{{route('busqueda').'?vendedorId='.$usuario->id .'&'.'enEdicion=1'}}" type="button" class="btn btn-info btn-lg"  style="width: 100%">Ver todos mis productos en edicion.</a>
					</div>
				</div>
			</div>
		</div>

		@else

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<div class="col-md-12">
						No hay productos en edicion!!
					</div>
				</div>
			</div>
		</div>

		@endif

		@php
			$productos = $usuario->productos()->where('valid', 0)->where('on_review', 1)->take(6)->get();
		@endphp

		@if($productos->count() > 0)

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-header">
					Productos en revision
				</div>
				<div class="col-md-12 card-body">
					<div class="col-xs-12">
						
						@foreach($productos as $producto)
						@php
							$producto = App\Producto::find($producto->id);
							$img = $producto->imagenes()->first();

							$comentarios = $producto->comentarios();
							$ranking = -1; 
                            $ranking = $producto->ranking;
							/*
							if($comentarios->count() != 0){
								$ranking = $comentarios->sum('ranking') / $comentarios->count();
							}
							*/

						@endphp
						<div class="col-sm-4 col-lg-3 col-md-3">
						    <div class="thumbnail">
						        <a href="{{route('verReviewProducto', $producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
						        </a>      
						        <div  style="overflow-y: hidden; height: 120px;">
						            <img src="{{URL::to('/') . '/' . $img->img_url}}" alt="" class="img-responsive">
						        </div>
						        <div class="caption">
						            <h4 class="">${{$producto->precio}} MX</h4>
						            <h4><a href="#">{{$producto->nombre}}</a></h4>
						            <p>{{$producto->desc_corta}}</p>
						        </div>
						        <div class="ratings">
						            <p>
					            	@for ($i = 0; $i < 5; $i++)
										@if($i < $ranking)
											<span class="glyphicon glyphicon-star "></span>
										@else
											<span class="glyphicon glyphicon-star-empty"></span>
										@endif
									@endfor

						            </p>
						        </div>
						    </div>
						</div>
						@endforeach
					</div>
					<div class="col-md-12">
						<a href="{{route('busqueda').'?vendedorId='.$usuario->id .'&'.'enRevision=1'}}" type="button" class="btn btn-info btn-lg"  style="width: 100%">Ver todos mis productos en revision.</a>
					</div>
				</div>
			</div>
		</div>

		@else

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<div class="col-md-12">
						No hay productos en revision!!
					</div>
				</div>
			</div>
		</div>

		@endif


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
	        <p>Empieza a comprar en nuestro sitio!!</p>
	        <p>Registrate o ingresa para poder comprar!!</p>
	        <div class="row">
	        	<a href="{{ route('register') }}" type="button" class="btn btn-info btn-lg" >Registrarse</a>
	        	<a href="{{ route('login') }}" type="button" class="btn btn-info btn-lg">Ingresa</a>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>

	  </div>
	</div>

@endsection