@extends('enterMain')
@section('form')
	<form role="form" class="form-body">
     	<span class="text-center"><h2>Entrar</h2></span>
		<div class="form-group">
		    <label class="control-label label-form" for="user">Correo:</label>
				<input type="email" class="form-control" id="user" placeholder="ejemplo@host.com">
		</div>
		<div class="form-group">
			<label class="control-label label-form" for="password ">Contraseña:</label>
			<input type="password" class="form-control" id="password" placeholder="Contraseña">
		</div>
	  	<button type="submit" class="btn btn-default" style="width: 100%;">Entrar</button>
	</form>
@endsection

@section('footer')
	<h4 class="text-center"  style="margin-bottom: 20px; ">¿No estas registrado?</h4>
	<h4 class="text-center" ><a  href="/register" class="text-center"  style="margin-bottom: 20px; ">Registrate hoy!</a></h4>
@endsection