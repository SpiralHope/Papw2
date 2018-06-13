@extends('enterMain')
@section('form')
    <form role="form" class="form-body" method="POST" action="{{ route('register') }}">
        @csrf
        <span class="text-center"><h2>Registrar Usuario</h2></span>
        <div class="form-group">
            <label class="control-label label-form" for="name">Nombre:</label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>Debe de tenerse un nombre</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label label-form" for="email">Correo:</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>Este correo ya ha sido registrado</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label label-form" for="password ">Contraseña:</label>
            <input id="password" type="password" class="form-control{{$errors->has('password')?' is_invalid':''}}" name="password" required>
            @if($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>Las contraseñas no son iguales</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label label-form" for="password_confirm ">Confirmar:</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-default" style="width: 100%;">Registrarse</button>

    </form>
@endsection

@section('footer')
    <h4 class="text-center"  style="margin-bottom: 20px; ">¿Ya tienes una cuenta?</h4>
    <h4 class="text-center" ><a  href="{{route('login')}}" class="text-center"  style="margin-bottom: 20px; ">Ingresa aqui!</a></h4>
    <h4 class="text-center"  style="margin-bottom: 20px; ">¿Quieres vender con nosotros?</h4>
    <h4 class="text-center" ><a  href="{{route('register2')}}" class="text-center"  style="margin-bottom: 20px; ">Registrate aqui!</a></h4>
@endsection