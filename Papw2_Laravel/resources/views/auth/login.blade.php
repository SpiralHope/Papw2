@extends('enterMain')
@section('form')
    <form role="form" class="form-body" method="POST" action="{{ route('login') }}">
        @csrf
        <span class="text-center"><h2>Entrar</h2></span>
        <div class="form-group">
            <label class="control-label label-form" for="email">Correo:</label>
                <input id="email" type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label class="control-label label-form" for="password ">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
             <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{'Recuerdame'}}
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-default" style="width: 100%;">Entrar</button>
    </form>
@endsection
@section('footer')
    <h4 class="text-center"  style="margin-bottom: 20px; ">¿No tienes una cuenta?</h4>
    <h4 class="text-center" ><a  href="{{route('register')}}" class="text-center"  style="margin-bottom: 20px; ">Ingresa aqui!</a></h4>
@endsection