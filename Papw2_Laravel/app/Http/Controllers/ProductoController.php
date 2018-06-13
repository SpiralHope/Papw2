<?php

namespace App\Http\Controllers;

use App\User;
use App\Comentario;
use App\Producto;
use App\ProductoImg;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function calcularRating($id_producto){

    	$producto = Producto::find($id_producto);
    	if($producto!= null){
    		$comentarios = $producto->comentarios()->orderBy('created_at', 'desc');
            $ranking = -1; 
            if($comentarios->count() != 0){
                $ranking = $comentarios->sum('ranking') / $comentarios->count();
            }
            $ranking = floor($ranking);
            $producto->ranking =  $ranking;
            $producto->reviews = $comentarios->count();
            $producto->save();
    	}

    }
    public function crearComentario(Request $request, $id_producto)
    {

    	$producto = Producto::find($id_producto);
    

    	if(	$producto!=null && $producto->valid == 1 && Auth::check() ){
	        if( $producto->comentarios()->where( 'id_usuario', Auth::user()->id )->count() == 0 ){

	        	$comDel = $producto->comentarios()->withTrashed()->where( 'id_usuario', Auth::user()->id );
	        	if( $comDel->count() != 0){
	        		$comDel->forceDelete();
	        	}
		        $comentario = new Comentario;
		        $comentario->ranking = $request->ranking;
		        $comentario->comentario = $request->comentario;

		        $comentario->id_usuario = $request->user()->id;
		        $comentario->id_producto = $id_producto;

		        $comentario->save();
//				$this->codigoError = "Se creo el comentario de manera exitosa!";
			}else{
				$comentario = Comentario::where('id_usuario', Auth::user()->id)->first();
		        $comentario->ranking = $request->ranking;
		        $comentario->comentario = $request->comentario;

		        $comentario->id_usuario = $request->user()->id;
		        $comentario->id_producto = $id_producto;

		        $comentario->update();
//				$this->codigoError = "Ya realizo un review en este producto!!";
			}
			$this->calcularRating($id_producto);
    	}else{
//	  		$this->codigoError = "Debe de estar registrado para hacer un review!!";
    	}

	   return redirect('producto/details/' . $id_producto);

        //return $this->mostrarProducto($id_producto); // view('user.profile', ['user' => User::findOrFail($id)]);
    }

    public function eliminarComentario(Request $request)
    {
    	$producto = Producto::find($request->producto);
    	if( Auth::check() ){
    		
    		if( Auth::user()->esAdmin() || Auth::user()->id == $producto->id_usuario ){
				$comentario = Comentario::find($request->review);
				if($comentario!=null)
				$comentario->delete();

				$this->calcularRating($producto->id);

    		}
    	}

	   return redirect('producto/details/' . $request->producto);
    }

    public function restaurarComentario(Request $request)
    {
    	$producto = Producto::find($request->producto);
    	if(Auth::check() ){
    		if(Auth::user()->esAdmin() || Auth::user()->id == $producto->id_usuario){
				$comentario = Comentario::onlyTrashed()->find($request->review);
				if($comentario!=null)
				$comentario->restore();

				$this->calcularRating($producto->id);
    		}
    	}
	   return redirect('producto/details/' . $request->producto);
    }

    public function mostrarProducto(Request $request, $producto){

    	$aComentado = false;
    	$comentarios = null;
    	$producto_mod = Producto::find($producto);
    	if($producto_mod == null || !$producto_mod->valid)
    		return redirect(route('landing'));

    	$comentarios = $producto_mod->comentarios();

    	if(Auth::check() ){
  			$aComentado = Producto::find($producto)->comentarios()->where( 'id_usuario', Auth::user()->id )->count() != 0;
    	}
    	
    	$queryString = $request->all();
    	$queryString = array_except($queryString, array('page'));

    	if($request->filled('orderby') ){
    		if($request->orderby == 'desc'){
    			$comentarios->orderby('created_at', 'desc');
    		}else if ($request->orderby == 'asc'){
				$comentarios->orderby('created_at', 'asc');
    		}else {
				$comentarios->orderby('created_at', 'desc');
				$queryString = array_except($queryString, array('orderby'));
    		}
    	}else {
			$comentarios->orderby('created_at', 'desc');
    		$queryString = array_except($queryString, array('orderby'));
    	}

		if(Auth::check()){
			if(Auth::user()->esAdmin()  || Auth::user()->id == $producto_mod->id_usuario ){
				$comentarios = $comentarios->withTrashed();
			}
		}

		$comentarios = $comentarios->paginate(1);

    	return view('detalle', compact('producto', 'producto_mod', 'aComentado','comentarios', 'queryString' ) );
	}

    public function verProductoRevision($id){
    	
    	if(Auth::check() && Auth::user()->esAdmin()){
    		$producto = Producto::find( $id )->where('on_review', 1)->where('valid', 0)->get()->first();
    		if($producto!= null && $producto->count() ){
    			$producto = Producto::find($id);
    			return view('producto_review', compact('producto'));
    		}else return redirect('dashboard');
    	}

    	return redirect( route('landing') );
    }

	public function rechazarProductoRevision($id){
		if(Auth::check() && Auth::user()->esAdmin()){
    		$producto = Producto::find($id);
    		if($producto!= null && $producto->valid != 1){
    			$producto->valid = 0;
    			$producto->on_review = 0;
    			$producto->update();
    		} 
    		return redirect('dashboard');
    	}
		return redirect( route('landing') );
	}

	public function validarProductoRevision($id){
		if(Auth::check() && Auth::user()->esAdmin()){
    		$producto = Producto::find($id);
    		if($producto!= null){
    			$producto->valid = 1;
    			$producto->on_review = 0;
    			$producto->update();
    			return redirect( route('producto', $id) );
    		}else return redirect('dashboard');
    	}

		return redirect( route('landing') );
	}

	public function verCrearProducto(){
		if(Auth::check() && Auth::user()->esVendedor() ){
			return view('crear_producto');
		}
		return redirect(route('landing'));
	}

	public function crearProducto(Request $request){
		$Validator = Validator::make($request->all(),[
			'imagen' => 'required|image',
			'nombre' => 'required|string|max:40',
			'descripcion' => 'required|string|max:255',
			'detalles' => 'required|string|max:255',
			'precio' => 'required|numeric|min:1',
			'categoria' => 'required|integer|min:1|exists:categorias,id',
		]);

		if($Validator->fails()){
			return redirect(route('verCrearProducto'))
			        ->withErrors($Validator)
			        ->withInput();
		}

		
		if(Auth::check() && Auth::user()->esVendedor()){

			$producto = new Producto;

			$path = null;

			if ($request->hasFile('imagen')) {
				if($request->file('imagen')->isValid()){
					$path = $request->imagen->store('public/images');
				}else return redirect(route('verCrearProducto'));
			}else return redirect(route('verCrearProducto'));


			$producto->nombre = $request->nombre;
			$producto->desc_corta = $request->descripcion;
			$producto->detalles = $request->detalles;
			$producto->precio = $request->precio;
			$producto->id_categoria = $request->categoria;
			$producto->ranking = 0;
			$producto->id_usuario = Auth::user()->id;

			$producto->save();

			$img = new ProductoImg;
			$img->id_producto = $producto->id;
			$img->img_url = $path;
			$img->save();
			
			return redirect(route('verEdicionProducto', $producto->id));

		}
		return redirect(route('landing'));


	}

	public function verEdicionProducto($id){
		$producto = Producto::find($id);
		if($producto != null && Auth::check() && Auth::user()->id == $producto->id_usuario && $producto->valid != 1 && $producto->on_review != 1){
			return view('editar_producto', compact('producto'));
		}
		return redirect( route('dashboard') );
	}



	public function agregarImgProducto(Request $request){
		
		$Validator = Validator::make($request->all(),[
			'imagen' => 'required|image',
			'producto' => 'required|integer'
		]);

		if($Validator->fails()){
			return redirect('dashboard')
			        ->withErrors($Validator)
			        ->withInput();
		}


		if(Auth::check() && Auth::user()->esVendedor()){

			$producto = Producto::find($request->producto);
    		if($producto!= null){

				if ($request->hasFile('imagen')) {
					if($request->file('imagen')->isValid()){
						$path = $request->imagen->store('public/images');

						$img = new ProductoImg;
						$img->id_producto = $producto->id;
						$img->img_url = $path;
						$img->save();

						return redirect(route('verEdicionProducto',$producto->id));
						
					}
				}
				
    		}
			

		}


		return redirect('dashboard');
	}

	public function borrarImgProducto(Request $request){

		$Validator = Validator::make($request->all(),[
			'id_img' => 'required|integer'
		]);

		if($Validator->fails()){
			return redirect('dashboard')
			        ->withErrors($Validator)
			        ->withInput();
		}

		if(Auth::check() && Auth::user()->esVendedor()){

			$img = ProductoImg::find($request->id_img);
    		if($img!= null){
				$producto = Producto::find($img->id_producto);
				if($producto!= null && $producto->id_usuario == Auth::user()->id ){
					if($producto->imagenes()->count() >1){
						if($img->img_url != null){
							Storage::delete($img->img_url);
						}
						$img->forceDelete();
					}

					return redirect(route('verEdicionProducto',$producto->id));
				}	
    		}
		}


		return redirect('dashboard');

	}

	public function editarProducto(Request $request){

		$Validator = Validator::make($request->all(),[
			'nombre' => 'required|string|max:40',
			'descripcion' => 'required|string|max:255',
			'detalles' => 'required|string|max:255',
			'precio' => 'required|numeric|min:1',
			'producto' => 'required|integer|min:1',
			'categoria' => 'required|integer|min:1',
		]);

		if($Validator->fails()){
			return redirect(route('verEdicionProducto', $request->producto))
			        ->withErrors($Validator)
			        ->withInput();
		}



		$producto = Producto::find($request->producto);
		if($producto != null && Auth::check() && Auth::user()->id == $producto->id_usuario){

			$producto->nombre = $request->nombre;
			$producto->desc_corta = $request->descripcion;
			$producto->detalles = $request->detalles;
			$producto->precio = $request->precio;
			$producto->id_categoria = $request->categoria;

			$producto->save();

			return redirect(route('verEdicionProducto', $request->producto));
		}


		return redirect('dashboard');
	}
	
	public function ponerRevisionProducto(Request $request){
		
		$Validator = Validator::make($request->all(),[
			'producto' => 'required|integer|min:1',
		]);

		if($Validator->fails()){
			return redirect(route('verEdicionProducto', $request->producto))
			        ->withErrors($Validator)
			        ->withInput();
		}

		$producto = Producto::find($request->producto);
		if($producto != null && Auth::check() && Auth::user()->id == $producto->id_usuario && $producto->valid != 1){

			$producto->on_review = 1;
			$producto->save();

			return redirect(route('verReviewProducto', $request->producto));
		}

		return redirect('dashboard');


	}

	public function verReviewProducto($id){
		$producto = Producto::find($id);
		if($producto != null && Auth::check() && Auth::user()->id == $producto->id_usuario && $producto->valid != 1 && $producto->on_review == 1){
			return view('editar_revision_producto', compact('producto'));
		}
		return redirect( route('dashboard') );
	}

}