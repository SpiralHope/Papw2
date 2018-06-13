@php
	use App\Producto;
	use App\User;
	use App\Comentario;

	use Carbon\Carbon;

	Carbon::setLocale('es');

	//$producto_mod = App\Producto::find($producto);
	//$comentarios = $producto_mod->comentarios()->orderBy('created_at', 'desc');

    $ranking = $producto_mod->ranking;
	
	$usuarioProducto = App\User::find($producto_mod->usuario()->first()->id);

	/*$producto_mod->created_at = Carbon::now();
	$producto_mod->save();*/

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
								<form role="form" class="form-body" method="POST" action="{{route('agregarCarrito')}}">
							     	{{csrf_field()}}
					     			<input type="number" name="producto" hidden value="{{$producto_mod->id}}" required style="display: none;">

							     	<div class="form-group">

							     		<div class="col-xs-6">
									    	<label class="control-label label-form float-left" for="cantidad">Cantidad</label>
							     			<input type="number" name="cantidad" class="form-control" id="cantidad" value="1" required min="1">
										</div>
							     		<div class="col-xs-6">
								  			@auth
								  			<button type="submit" id="btnComprar" class="btn btn-default" >Comprar</button>
							     			@else
											<button id="btnComprar" type="button"  class="btn btn-default" data-toggle="modal" data-target="#myModal">Comprar</button>
							     			@endauth

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
				@auth
				@if( Auth::user()->id != $producto_mod->id_usuario )

				@if($aComentado)
				<div class="col-md-8 col-md-offset-2">
					<div class="mensaje-review">
						<p>Ya ha dejado una reseña!!</p>
						<p>Puede modificar su reseña debajo</p>
					</div>
				</div>
				@endif
				<div class="col-md-8 col-md-offset-2">
					<form role="form" action="{{URL::to('/') . '/producto/comentar/'.$producto_mod->id}}" class="form-body" style="border: initial; width: 100%" method="POST">
						{{csrf_field()}}			
						<div class="card-body">
							<div style="margin: 0px 0px 10px;"> 
								<input type="text" class="form-control" id="comentario" name="comentario" placeholder="Deja tu reseña">
							</div>
							<div class="rating">
							    <span ><input type="radio" required name="ranking" id="str5" value="5"><label class="glyphicon glyphicon-star" for="str5"></label></span>
							    <span><input type="radio" required name="ranking" id="str4" value="4"><label class="glyphicon glyphicon-star" for="str4"></label></span>
							    <span><input type="radio" required name="ranking" id="str3" value="3"><label class="glyphicon glyphicon-star" for="str3"></label></span>
							    <span><input type="radio" required name="ranking" id="str2" value="2"><label class="glyphicon glyphicon-star" for="str2"></label></span>
							    <span><input type="radio" required name="ranking" id="str1" value="1"><label class="glyphicon glyphicon-star" for="str1"></label></span>
							</div>
							<button type="submit" class="btn btn-default" style="width: 100%;">Dejar Review</button>

							<script type="text/javascript">
								$(document).ready(function(){
								    // Check Radio-box
								    $(".rating input:radio").prop("checked", false);

								    $('.rating input').click(function () {
								        $(".rating span").removeClass('checked');
								        $(this).parent().addClass('checked');
								    });

								    /*
									    $('input:radio').change(
									      function(){
									        var userRating = this.value;
									        alert(userRating);
									    }); 
									*/
								});
							</script>
						</div>
					</form>
				</div>
				@else
				<div class="col-md-8 col-md-offset-2">
					<div class="mensaje-review">
						No puede dejar reviews en sus productos!!
					</div>
				</div>
				@endif

				@else
				<div class="col-md-8 col-md-offset-2">
					<div class="mensaje-review">
						Registrate para poder dejar un review
					</div>
				</div>
				@endauth
			</div>
		</div>
		
	</div>

	<!-- Reseñas Producto -->
	<div class="row comentarios-section" id="reviews">
		<div class="col-md-12">
			<div class="card">
				<div class="col-md-12" style="padding: 10px;">
					<div style="float:right;">
						<a href="{{route('producto', $producto_mod->id) .'?orderby=asc#reviews'}}" class="btn btn-default" style="padding-top: 11px;"><span class="glyphicon glyphicon-chevron-up" style="color: #17396b;"></span></a>
					</div>
					<div style="float:right; margin-right:10px;">
						<a href="{{route('producto', $producto_mod->id) .'?orderby=desc#reviews'}}" class="btn btn-default" style="padding-top: 11px;"><span class="glyphicon glyphicon-chevron-down" style="color: #17396b;"></span></a>
					</div>
				</div>
				@foreach($comentarios as $comentario)
					@php
						$usuarioComentario = App\User::find($comentario->id_usuario);
					@endphp
					<div class="col-md-8 col-md-offset-2 comentario-contenedor">
						<div class="comentario-avatar">
							<div class="comentario-img">
								<a href="{{route('perfil').'/'.$usuarioComentario->id }}">
									<img class="img-responsive img-thumbnail" src="{{URL::to('/') . '/' . $usuarioComentario->imagen()}}">
								</a>
							</div>
						</div>
						<div class="comentario-contenido">
							<div class="comentario-header">
								@auth
									@if( Auth::user()->esAdmin() || Auth::user()->id == $usuarioProducto->id )
										@if($comentario->trashed())
										<a href="{{route('restaurarReview')}}" type="button" class="close review " data-toggle="Restaurar Reseña" onclick="event.preventDefault(); document.getElementById('restaurar-comentario-{{$comentario->id}}').submit();">
										    <span class="glyphicon glyphicon-repeat"></span></a>
										<form id="restaurar-comentario-{{$comentario->id}}" action="{{route('restaurarReview')}}" method="POST" style="display: none;">
											@csrf
											<input type="hidden" name="_method" value="put" />
											<input type="number" name="review" value="{{$comentario->id}}" >
											<input type="number" name="producto" value="{{$producto_mod->id}}" >
										</form>

										@else 
										<a href="{{route('eliminarReview')}}" type="button" class="close review" data-toggle="Eliminar Reseña" onclick="event.preventDefault(); document.getElementById('eliminar-comentario-{{$comentario->id}}').submit();">
										    <span class="glyphicon glyphicon-remove"></span></a>
										<form id="eliminar-comentario-{{$comentario->id}}" action="{{route('eliminarReview')}}" method="POST" style="display: none;">
											@csrf
											<input type="hidden" name="_method" value="delete" />
											<input type="number" name="review" value="{{$comentario->id}}" >
											<input type="number" name="producto" value="{{$producto_mod->id}}" >
										</form>
										@endif
									@endif
								@endauth
								<div class="comentario-nombre">
									<a href="{{route('perfil').'/'.$usuarioComentario->id }}">{{$usuarioComentario->name}}</a>
								</div>
								@if($comentario->updated_at != $comentario->created_at )
								<div class="text-muted comentario-fecha">
									Editado
								</div>
								@endif
								<div class="text-muted comentario-fecha">
									{{$comentario->created_at->diffForHumans()}}
								</div>
								<div class="comentario-ranking">
									@for ($i = 0; $i < 5; $i++)
										@if($i < $comentario->ranking)
											<span class="glyphicon glyphicon-star "></span>
										@else
											<span class="glyphicon glyphicon-star-empty"></span>
										@endif
									@endfor
								</div>
							</div>
							<div class="comentario-datos">
								<div class="">
									{{$comentario->comentario }}
								</div>
							</div>
						</div>
					</div>
				@endforeach	
				 <nav aria-label="Page navigation example" class="text-center">
			      {{ $comentarios->appends($queryString)->fragment('reviews')->links() }}
			    </nav>
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