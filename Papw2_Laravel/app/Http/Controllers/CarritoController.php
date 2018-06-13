<?php

namespace App\Http\Controllers;

use App\User;
use App\Comentario;
use App\Producto;
use App\CarritoDetalle;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{

    public function verCarrito() {
	   	if( Auth::check() ){
	   		return view('carrito');
	   	}else{
	   		return redirect(route('landing'));
	   	}
    }

    public function agregarProducto(Request $request){
    	$validator = Validator::make($request->all(), [
           'producto' => 'required|integer|min:1',
            'cantidad' => 'required|integer|min:1'
        ]);

    	if ($validator->fails()) {
            return redirect('carrito')
                        ->withErrors($validator)
                        ->withInput();
        }

        $producto = Producto::find($request->producto);



    	if($producto!=null && $producto->valid && Auth::check() && $producto->id_usuario != Auth::user()->id){

            $item = CarritoDetalle::where('id_producto', $request->producto)->where('id_usuario', Auth::user()->id);
    		if($item->count() == 0){

    			$item = new CarritoDetalle();
    			$item->id_usuario = Auth::user()->id;
    			$item->id_producto = $request->producto;
    			$item->cantidad = floor($request->cantidad);
    			$item->save();
    		}else{
    			$item = CarritoDetalle::find($item->get()->first()->id);
    			$item->cantidad = $item->cantidad + floor($request->cantidad);
    			$item->update();
    		}
    	}
	   	return redirect('carrito');
    }

    public function eliminarProducto(Request $request){
	   	if(Auth::check()){
    		$item = CarritoDetalle::where('id', $request->carrito)->where('id_usuario', Auth::user()->id);
    		if($item->count() != 0){
    			$item->delete();
    		}
    	}
	   	return redirect('carrito');
    }

  
    public function modificarProducto(Request $request){

    	$validator = Validator::make($request->all(), [
           'cantidad' => 'required|integer|min:1',
            'carrito' => 'required|integer|min:1'
        ]);

    	if ($validator->fails()) {
            return redirect('carrito')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		if(Auth::check()){
    		$item = CarritoDetalle::where('id', $request->carrito)->where('id_usuario', Auth::user()->id);
    		if($item->count() != 0 ){
    			$item = CarritoDetalle::find($item->get()->first()->id);
    			$item->cantidad = floor($request->cantidad);
    			$item->save();
    		}
    	}
	   return redirect('carrito');
    }

    public function vaciarCarrito(){
    	if(Auth::check()){
    		$carrito = CarritoDetalle::where('id_usuario', Auth::user()->id)->delete();

    	}
	   return redirect('carrito');
    }

    public function comprarCarrito(){
	   return $this->vaciarCarrito();
    }

}
