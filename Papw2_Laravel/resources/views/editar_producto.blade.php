@php
	use App\Producto;
	use App\User;
	use App\Comentario;
	use App\Categoria;

	use Carbon\Carbon;

	Carbon::setLocale('es');

	$producto_mod = $producto;
	
	$ranking = -1; 
	
	$usuarioProducto = App\User::find($producto_mod->usuario()->first()->id);
	$categorias = App\Categoria::all();


@endphp

@extends('master')

@section('title', $producto_mod->nombre)

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

@if(false)
 	@foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
@endif
	<!-- Producto -->

	<div class="row">
		
		<!-- Bread -->
		<div class="col-md-12">
			<ol class="breadcrumb" style="padding: 12px; font-size: 18px;">
				<li class=""><a href="{{route('busqueda')}}">Productos</a></li>
				<li class=""><a href="{{route('busqueda').'?categoria='.$producto_mod->categoria()->first()->id}}">{{$producto_mod->categoria()->first()->nombre}}</a></li>
				<li class=""><a href="{{route('busqueda').'?vendedorId='.$producto_mod->id_usuario .'&'.'enEdicion=1'}}">Edicion</a></li>
				<li class=" active">{{$producto_mod->nombre}}</li>
			</ol>
		</div>

		<style type="text/css">
			.editar-producto-img-cont{
				position: relative;
				width: 100%;
				height: 100%;
			}
			.editar-producto-img-cont{
				display: block;
			}
			#modify-perfil-section .editar-producto-img-cont.img-relative a{
				background-color: rgba(0,0,0, 0.2);
				width: 100%;
				height: 100%;
				top: 0px;
				transition: all 0.2s;

				padding-top: calc( 32%);
			}
			#modify-perfil-section .editar-producto-img-cont.img-relative a:hover{
				background-color: rgba(0,0,0, 0.8);
				transition: all 0.2s;
			}

			#modify-perfil-section .editar-producto-img-cont.img-relative a#add-img{
				background-color: rgba(0,0,95, 0.2);
			}
			#modify-perfil-section .editar-producto-img-cont.img-relative a#add-img:hover{
				background-color: rgba(0,0,95, 0.8);
			}

			#modify-perfil-section .nombre .perfil-nombre span.highlight, #modify-perfil-section .nombre .perfil-descripcion span.highlight{
				font-size: 16px;

			}
			#modify-perfil-section .nombre .perfil-nombre, #modify-perfil-section .nombre .perfil-descripcion{
				padding: 11px 0px;
			}

			#modify-perfil-section{
				margin-bottom: 40px;
			}

		</style>

		<!-- Editar Producto -->
		<div class="col-md-12" id="modify-perfil-section">
			<div class="card" >
				<div class="col-md-12 text-right card-header" style="font-size: 25px;">
					<div class="ranking-header">
						@for ($i = 0; $i < 5; $i++)
							<span class="glyphicon glyphicon-star text-muted"></span>
						@endfor
					</div>
					<span class="text-muted">Edicion: </span>{{$producto_mod->nombre}}
				</div>
				<div class="col-md-12 card-body">
						<div class="col-md-7">
							@php
								$imagenes = $producto_mod->imagenes()->get();
							@endphp

							<div id="myCarousel2" class="carousel slide" data-ride="carousel" data-interval="false">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<li class="active" data-target="#myCarousel2" data-slide-to="0"></li>@for ($i = 0; $i < $imagenes->count(); $i++)
								  	<li data-target="#myCarousel2" data-slide-to="{{$i + 1}}"></li>
								@endfor
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner" style="height: 420px;" role="listbox">

								<div class="item carousel-item text-center active" >
									<div class="editar-producto-img-cont img-relative">
										<a href=""	id="add-img-send">Agregar Imagen</a>
										<form action="{{route('editarAgregarImg')}}" method="POST" enctype="multipart/form-data" id="add-img-form" style="display: none">
											@csrf
											<input type="number" name="producto" autocomplete="off" value="{{$producto_mod->id}}">	
											<input type="file" name="imagen" autocomplete="off" id="add-input">	
										</form>
										@push('scripts')
										<script type="text/javascript">
											$(document).ready(function(){
												$('#add-img-send').click(function(event) {
													/* Act on the event */
													event.preventDefault();
													$('#add-input').trigger('click');
												});

												$('#add-input').change(function(event) {
													/* Act on the event */
													if($(this).val()!=""){
														$('#add-img-form').submit();
													}
												});
											});
										</script>
										@endpush
									</div>
								</div>

								@foreach ($imagenes as $imgs)
								<div class="item carousel-item text-center " >
									<div class="editar-producto-img-cont img-relative">
										<img class="item-img-carousel img-" src="{{URL::to('/') .'/'. $imgs->img_url }}">
										<a href="" id="borrar-img-{{$imgs->id}}">Borrar Imagen</a>
										<form action="{{route('editarBorrarImg')}}" method="POST" enctype="multipart/form-data" id="delete-img-form-{{$imgs->id}}" style="display: none">
											@csrf
											<input type="number" name="id_img" autocomplete="off" value="{{$imgs->id}}">
										</form>

										@push('scripts')
										<script type="text/javascript">
											$(document).ready(function(){
												$('#borrar-img-{{$imgs->id}}').click(function(event) {
													/* Act on the event */
													event.preventDefault();
													$('#delete-img-form-{{$imgs->id}}').submit();
												});
											});
										</script>
										@endpush
									</div>
								</div>
								@endforeach
							</div>

							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel2" data-slide="prev" role="button">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel2" data-slide="next" role="button">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Next</span>
							</a>
							</div>

						</div> 
						<!--End of carousel -->

						<div class="col-md-5 desc-cont">
						
							<div class="div-descripcion">	
								<form id="modificar-post" method="POST" action="{{route('editarProducto')}}">
									@csrf
									<input type="number" name="producto" value="{{$producto_mod->id}}" required style="display: none"> 

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
										<input type="text" class="form-control required" name="nombre" value="{{$producto_mod->nombre}}" autocomplete="off" required> 
									</div>
									<div class="form-group">
										<input type="text" class="form-control required" name="descripcion"  value="{{$producto_mod->desc_corta}}" autocomplete="off" required> 
									</div>
									<div class="form-group">
										<input type="text" class="form-control required" name="detalles" value="{{$producto_mod->detalles}}" autocomplete="off" required> 
									</div>
									<div class="form-group">
										<input type="number" class="form-control required" name="precio" value="{{$producto_mod->precio}}" autocomplete="off" required min="1"> 
									</div>
									<div class="form-group">
										<select name="categoria" type="number" class="form-control required" autocomplete="off" required>
											@foreach($categorias as $categoria)
											<option value="{{$categoria->id}}" @if($producto_mod->id_categoria == $categoria->id) selected @endif>{{$categoria->nombre}}</option>
											@endforeach
										</select>
									</div>
								</div>

								</form>
								
								<a href="#" type="button" class="btn btn-info btn-lg" style="width: calc(100% - 20px); margin: 5px 10px;" id="modificarProducto" >Modificar</a>
								<a href="#" type="button" class="btn btn-info btn-lg" style="width: calc(100% - 20px); margin: 5px 10px;" id="revisionProducto" >Colocar en revision</a>
								<form  id="revisar-producto" style="display: none" method="POST" action="{{route('colocarRevisionProducto')}}">
									@csrf
									<input type="number" name="producto" value="{{$producto_mod->id}}">
								</form>
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

										    $('#modificarProducto').click(function(event) {
										    	event.preventDefault();
										    	if(check_required_inputs()){
										    		$('#modificar-post').submit();
										    	}else{
										    		$('#myModal').modal('show');
										    	}

										    });

										     $('#revisionProducto').click(function(event) {
										    	event.preventDefault();
									    		$('#revisar-producto').submit();
										    });
										});
									</script>
								@endpush

							
								
							</div>
						</div>
					<div class="col-md-12">
					
					</div>
				</div>
			</div>
		</div>

		<!-- Descripcion Producto -->
		<div class="col-md-12">
			<div class="card" >
				<div class="col-md-12 text-right card-header" style="font-size: 25px;">
					<div class="ranking-header">
						@for ($i = 0; $i < 5; $i++)
							<span class="glyphicon glyphicon-star text-muted"></span>
						@endfor
					</div>
					<span class="text-muted">Preview: </span>{{$producto_mod->nombre}}
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
								<form role="form" class="form-body" method="POST" action="{{route('agregarCarrito')}}">
							     	{{csrf_field()}}
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