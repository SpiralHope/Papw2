<?php

namespace App\Http\Controllers;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    //

	 public function verPerfil($id = -1){
	 	$usuario = null;
	 	$es_editable = false;
	 	if($id == -1 && Auth::check()){
 			$usuario = Auth::user();
 			$es_editable = true;
 			return view('perfil', compact('usuario', 'es_editable'));
	 	}else{
	 		$usuario = User::find($id);
	 		if( $usuario != null && $usuario->count() != 0){
	 			if(Auth::check() && $usuario->id == Auth::user()->id ){
 					$es_editable = true;
	 			}
	 			return view('perfil', compact('usuario', 'es_editable'));
	 		}
	 	}

		return redirect(route('landing'));

	 }

	public function modificarPerfil(Request $request){
		
		$Validator = Validator::make($request->all(),[
			'imagen' => 'image',
			'nombre' => 'string|max:20',
			'biografia' => 'string|max:255'
		]);

		if($Validator->fails()){
			return redirect('perfil')
			        ->withErrors($Validator)
			        ->withInput();
		}

		if(Auth::check()){
			$usuario = Auth::user();
			//$array = array_filter($request->all());

			if ($request->hasFile('imagen')) {
				if($request->file('imagen')->isValid()){

					if($usuario->img != null){
						Storage::delete($usuario->img);
					}

					$path = $request->imagen->store('public/images');
					$usuario->img = $path;
				}
			}

			if($request->has('nombre')){
				$usuario->name = $request->nombre;
			}

			if($request->has('biografia')){
				$usuario->biografia = $request->biografia;
			}

			$usuario->update();
		}


		return redirect('perfil');
	}

	

}
