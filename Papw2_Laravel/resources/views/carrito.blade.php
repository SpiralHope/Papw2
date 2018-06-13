@php
	use App\Producto;
	use App\User;
	use App\Comentario;
	use App\CarritoDetalle;

	use Carbon\Carbon;

	$itemsCarrito = App\CarritoDetalle::where('id_usuario', Auth::user()->id)->get();

@endphp

@extends('master')

@section('title', 'Carrito')

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
				<li class=""><a href="#">Carrito</a></li>
			</ol>
		</div>

		<!-- Descripcion Producto -->
		<div class="col-md-12">
			<div class="card" >
				<div class="col-md-12 card-body">
					@php
						$total = 0;
					@endphp
					@foreach($itemsCarrito as $item)
						@php
							$producto = App\Producto::find($item->id_producto);
							$imagen = $producto->imagenes()->first();
							$total += $producto->precio * $item->cantidad;
						@endphp
						<div class="col-md-8 col-md-offset-2 item-contenedor">	
						<div class="item-avatar">
							<div class="item-img">
								<a href="{{route('producto').'/'.$producto->id }}">
									<img class="img-responsive img-thumbnail" src="{{URL::to('/') . '/' . $imagen->img_url}}">
								</a>
							</div>
						</div>
						<div class="item-contenido">
							<div class="item-header">
								<div class="item-nombre">
									<a href="{{route('producto').'/'.$producto->id }}">{{$producto->nombre}}</a>
								</div>
							</div>
							<div class="text-muted item-fecha">
									{{/*$item->created_at->diffForHumans()*/
									'$' . $producto->precio}} / {{'$' . number_format ($producto->precio * $item->cantidad, 2)}}
								
							</div>
							<div class="item-datos">
								<div class="">
									<form action="{{route('modificarCarrito')}}" method="POST" id="modificar-carrito">
										@csrf
								    	<label class="control-label label-form float-left" for="cantidad">Cantidad</label>
						     			<input type="number" name="cantidad" class="form-control" id="cantidad-carrito" value="{{$item->cantidad}}" required min="1" autocomplete="off">
										<input type="number" name="carrito" value="{{$item->id}}"  style="display: none;">
									</form>
								</div>
							</div>
						</div>
						<div class="item-modify">
							<a href="{{route('modificarCarrito')}}" class="btn" onclick="event.preventDefault(); document.getElementById('modificar-carrito').submit();"> <span class="glyphicon glyphicon-repeat"></span></a>
							<a href="{{route('eliminarCarrito')}}" class="btn" onclick="event.preventDefault(); document.getElementById('eliminar-{{$item->id}}').submit();"> <span class="glyphicon glyphicon-remove"></span></a>

							<form id="eliminar-{{$item->id}}" action="{{route('eliminarCarrito')}}" method="POST" style="display: none;">
								@csrf
								<input type="number" name="carrito" value="{{$item->id}}" >
							</form>
						</div>
					</div>


					@endforeach
					<div class="col-md-8 col-md-offset-2 item-contenedor text-right" >	
						Total: {{'$' . number_format ($total) }}
					</div>
					<div class="col-md-8 col-md-offset-2 item-contenedor text-right" >	
						<a href="{{ route('comprarCarrito') }}" type="button" class="btn btn-info btn-lg" onclick="event.preventDefault(); document.getElementById('comprar-carrito').submit();" >Comprar</a>
	        			<a href="{{ route('vaciarCarrito') }}" type="button" class="btn btn-info btn-lg" onclick="event.preventDefault(); document.getElementById('vaciar-carrito').submit();">Vaciar</a>
	        			<form id="vaciar-carrito" action="{{route('vaciarCarrito')}}" method="POST" style="display: none;">
							@csrf
						</form>
						<form id="comprar-carrito" action="{{route('comprarCarrito')}}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
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