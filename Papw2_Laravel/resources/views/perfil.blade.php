@php
	use App\Producto;
	use App\User;
	use App\Comentario;
	use App\CarritoDetalle;

	use Carbon\Carbon;


@endphp

@extends('master')
@if($es_editable)
	@section('title', 'Mi Perfil')
@else
	@section('title', 'Perfil de '.$usuario->name)
@endif
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
				<li class=""><a href="#">Perfil</a></li>
				<li class=" active">{{ $usuario->name }}</li>
			</ol>
		</div>

		<!-- Descripcion Producto -->
		<div class="col-md-12" id="perfil-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<div class="col-md-3 img-perfil">
						<img class="img-responsive img-thumbnail" src="{{URL::to('/') . '/' . $usuario->imagen()}}">
					</div>
					<div class="col-md-9">
						<div class="perfil-nombre">
							<span class="highlight">Nombre: </span>{{$usuario->name}}
						</div>
						<div class="perfil-descripcion">
							<span class="highlight">Biografia: </span>{{$usuario->biografia()}}
						</div>
					</div>
					@if($es_editable)
					<div class="col-md-12 text-right" >	
						<a href="#" type="button" class="btn btn-info btn-lg" id="mostrarModificar" >Modificar</a>
					</div>
					
						
					@endif
				</div>
			</div>
		</div>


		@if($es_editable)
		<div class="col-md-12" id="modify-perfil-section" style="display: none">
			<div class="card" >
				<div class="col-md-12 card-body">
					<form method="POST" action="{{route('modificarPerfil')}}" enctype="multipart/form-data" id="modificar-post">
						@csrf
					<div class="col-md-3 img-perfil img-relative">
						<div class="container-div">
							<img class="img-responsive img-thumbnail" src="{{URL::to('/') . '/' . $usuario->imagen()}}">
							<div class="gray-background"></div>
							<a href="" >Buscar Imagen</a>
							<input type="file" name="imagen" autocomplete="off" id="imagen-modificar"> 		
						</div>
					</div>
					<div class="col-md-9">
						<div class="nombre">
							<div class="perfil-nombre">
								<span class="highlight">Nombre: </span>
							</div>
							<div class="perfil-descripcion">
								<span class="highlight">Biografia: </span>
							</div>
						</div>
						<div class="inputs">
							<div class="form-group">
								<input type="text" class="form-control" name="nombre" value="{{$usuario->name}}" autocomplete="off"> 
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="biografia" value="{{$usuario->biografia()}}" autocomplete="off"> 
							</div>
						</div>
					</div>
					
					<div class="col-md-12 text-right" >	
						<a href="#" type="button" class="btn btn-info btn-lg" id="cancelarModificar" >Cancelar</a>
						<a href="#" type="button" class="btn btn-info btn-lg" id="modificarPerfil" >Modificar</a>
						@push('scripts')
							<script type="text/javascript">
								$(document).ready(function(){
								    $('#mostrarModificar').click(function(event) {
								    	event.preventDefault();
								   		$('#perfil-section').hide();
								   		$('#modify-perfil-section').show();
								    });
								    $('#cancelarModificar').click(function(event) {
								    	event.preventDefault();
								   		$('#perfil-section').show();
								   		$('#modify-perfil-section').hide();
								    });
								    $('#modificarPerfil').click(function(event) {
								    	event.preventDefault();
								    	$('#modificar-post').submit();
								    });

								});
							</script>
						@endpush
					</div>
					</form>

				</div>
			</div>
		</div>
		@endif

		@if($usuario->esVendedor() )
		@php
			$productos = $usuario->productos()->where('valid', 1)->take(6)->get();
		@endphp

		<div class="col-md-12" id="perfil-productos-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<div class="col-md-12">
						@foreach($productos as $producto)
						@php
							$producto = App\Producto::find($producto->id);
							$img = $producto->imagenes()->first();

							$comentarios = $producto->comentarios()->orderBy('created_at', 'desc');
							$ranking = -1; 
							if($comentarios->count() != 0){
								$ranking = $comentarios->sum('ranking') / $comentarios->count();
							}

						@endphp
						<div class="col-sm-4 col-lg-3 col-md-3">
						    <div class="thumbnail">
						        <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
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
						            <p class="pull-right">{{$comentarios->count()}} reseñas</p>
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
						<a href="{{route('busqueda').'?vendedorId='.$usuario->id}}" type="button" class="btn btn-info btn-lg"  style="width: 100%">Ver mas productos!!</a>
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