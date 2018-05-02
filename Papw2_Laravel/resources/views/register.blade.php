@extends('enterMain')
@section('form')
	<form role="form" class="form-body">
			<div class="form-group">
		    <label class="control-label label-form" for="user">Usuario:</label>
  			<input type="text" class="form-control" id="user" placeholder="Usuario">
		</div>
		<div class="form-group">
		    <label class="control-label label-form" for="user">Correo:</label>
  			<input type="email" class="form-control" id="user" placeholder="ejemplo@host.com">
		</div>
		<div class="form-group">
			<label class="control-label label-form" for="password ">Contraseña:</label>
			<input type="password" class="form-control" id="password" placeholder="Contraseña">
		</div>
	  	<button type="submit" class="btn btn-default" style="width: 100%;">Registrarse</button>

	</form>
@endsection

@section('footer')
	<h4 class="text-center"  style="margin-bottom: 20px; ">¿Ya tienes una cuenta?</h4>
	<h4 class="text-center" ><a  href="http://localhost:8000/login" class="text-center"  style="margin-bottom: 20px; ">Ingresa aqui!</a></h4>
@endsection