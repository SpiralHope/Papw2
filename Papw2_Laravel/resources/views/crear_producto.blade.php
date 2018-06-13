@php
	use App\Producto;
	use App\User;
	use App\Comentario;
	use App\Categoria;
	use App\CarritoDetalle;

	use Carbon\Carbon;

	$categorias = App\Categoria::all();

@endphp

@extends('master')
	@section('title', 'Crear Producto')
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
				<li class="active">Crear Producto</li>
			</ol>
		</div>

		<div class="col-md-12 crear-producto-vendedor" id="modify-perfil-section">
			<div class="card" >
				<div class="col-md-12 card-body">
					<form method="POST" action="{{route('crearProducto')}}" enctype="multipart/form-data" id="modificar-post">
						@csrf

					
					<div class="col-md-12">
						<div class="nombre " style="text-align: right;">
							<div class="perfil-nombre">
								<span class="highlight">Nombre: </span>
							</div>
							<div class="perfil-descripcion">
								<span class="highlight">Descripcion: </span>
							</div>
							<div class="perfil-nombre">
								<span class="highlight">Detalles: </span>
							</div>
							<div class="perfil-nombre">
								<span class="highlight">Precio: </span>
							</div>
							<div class="perfil-nombre">
								<span class="highlight">Categoria: </span>
							</div>
						</div>
						<div class="inputs">
							<div class="form-group">
								<input type="text" class="form-control required" name="nombre" autocomplete="off" required> 
							</div>
							<div class="form-group">
								<input type="text" class="form-control required" name="descripcion" autocomplete="off" required> 
							</div>
							<div class="form-group">
								<input type="text" class="form-control required" name="detalles" autocomplete="off" required> 
							</div>
							<div class="form-group">
								<input type="number" class="form-control required" name="precio" autocomplete="off" required min="1"> 
							</div>
							<div class="form-group">
								<select name="categoria" type="number" class="form-control required" autocomplete="off" required>
									@foreach($categorias as $categoria)
									<option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="col-md-4 col-md-offset-4 img-perfil img-relative">
						<div class="container-div img-crear-producto">
							<div class="gray-background"></div>
							<a href="" >Buscar Imagen</a>
							<input type="file" name="imagen" autocomplete="off" id="imagen-modificar" required> 		
						</div>
					</div>
					
					<div class="col-md-12 text-right" >	
						<a href="#" type="button" class="btn btn-info btn-lg" id="crearProducto" >Crear</a>
						@push('scripts')
							<script type="text/javascript">
								$(document).ready(function(){

									function check_required_inputs() {
										var valid = true;
									    $('.required').each(function(){
									        if( $(this).val() == "" ){
									        	valid = false;
									        	return false;
									        }
									    });
									    return valid;
									};


								    $('#crearProducto').click(function(event) {
								    	event.preventDefault();
								    	if(check_required_inputs()){
								    		$('#modificar-post').submit();
								    	}else{
								    		$('#myModal').modal('show');
								    	}
									    

								    });
								});
							</script>
						@endpush
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
	        <p>Llene todos los campos por favor!</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>

	  </div>
	</div>

@endsection