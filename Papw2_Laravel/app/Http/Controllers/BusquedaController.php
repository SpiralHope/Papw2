<?php

namespace App\Http\Controllers;


use App\User;
use App\Comentario;
use App\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BusquedaController extends Controller
{
    //

    public function buscar(Request $request){
    	
    	$productos = null;


    	$queryString = $request->all();
    	$queryString = array_except($queryString, array('page') );

    	$buscoAlgo = false;

    	if($request->filled('vendedorId')){
    		
    		$buscoAlgo = true;

    		$productos =  User::find( $request->vendedorId )->productos();

    		
    		if(Auth::check() && Auth::user()->id == $request->vendedorId  && $productos != null){

	    		if($request->filled('enEdicion') && $request->enEdicion == 1 && $request->filled('enRevision') && $request->enRevision == 1){

				}	
	    		else if($request->filled('enEdicion') && $request->enEdicion == 1 ){
	    			$productos = $productos->where('valid', 0)->where('on_review', 0);

	    		}
	    		else if($request->filled('enRevision') && $request->enRevision == 1){
	    			$productos = $productos->where('valid', 0)->where('on_review', 1);
	    		}else{
	    			$productos = $productos->where('valid', 1);
	    		}

    		}else if($productos != null){
    			$productos = $productos->where('valid', 1);
    		}

    	}else $queryString = array_except($queryString, array('vendedorId', 'enEdicion', 'enRevision') );

    	if($request->filled('revision') && $request->revision == 'true' && Auth::check() && Auth::user()->esAdmin() ){
    		$buscoAlgo = true;
    		if($productos == null){
    			$productos =  Producto::where('valid', 0)->where('on_review', 1);
    		}else{
    			$productos = $productos->where('valid', 0)->where('on_review', 1);
    		}
    	}else $queryString = array_except($queryString, array('revision') );


    	if($request->filled('nombre') ){
    		$buscoAlgo = true;
    		if($productos == null){
    			$productos =  Producto::where('nombre','like', '%'.$request->nombre.'%')->where('valid', 1);
    		}else{
    			$productos = $productos->where('nombre','like', '%'.$request->nombre.'%');
    		}
    	}else $queryString = array_except($queryString, array('nombre') );

        if($request->filled('autor') ){
            $buscoAlgo = true;
            $autor = User::where('name', 'like', '%'.$request->autor.'%')->get()->first();
            if( $autor!=null ){
                if($productos == null){
                    $productos =  Producto::where('id_usuario', $autor->id)->where('valid', 1);
                }else{
                    $productos = $productos->where('id_usuario', $autor->id);
                }
            }else{
                $productos =  Producto::where('id_usuario', -1)->where('valid', 1);
            }
        }else $queryString = array_except($queryString, array('autor') );


        if($request->filled('antes') && $request->filled('despues') ){

            $antes = Carbon::createFromFormat('d/m/Y', $request->antes );
            $despues = Carbon::createFromFormat('d/m/Y', $request->despues );

            $buscoAlgo = true;
            
            if($antes !== false &&  $despues !== false){
                $antes = $antes->format('Y-m-d');
                $despues = $despues->format('Y-m-d');

                if($despues > $antes)
                {
                    $temp =  $antes;
                    $antes = $despues;
                    $despues = $temp;

                    $temp = $queryString['antes'];
                    $queryString['antes'] = $queryString['despues'];
                    $queryString['despues'] = $temp;
                }

                if($productos == null){
                    $productos =  Producto::whereBetween('created_at', [$despues, $antes])->where('valid', 1);
                }else{
                    $productos = $productos->whereBetween('created_at', [$despues, $antes]);
                }


            }

        }else $queryString = array_except($queryString, array('antes', 'despues') );

        

    	if($request->filled('categoria') && $request->categoria > 0 ){
    		$buscoAlgo = true;
    		if($productos == null){
    			$productos =  Producto::where('id_categoria', $request->categoria)->where('valid', 1);
    		}else{
    			$productos = $productos->where('id_categoria', $request->categoria);
    		}
    	}else $queryString = array_except($queryString, array('categoria') );


    	if($productos == null && !$buscoAlgo){
    		$productos =  Producto::where('valid', 1);
    	}

    	if($productos != null){
            $productos = $productos->orderBy('created_at', 'desc');
    		$productos = $productos->paginate(6);
    	}


    	return view('busqueda', ['productos' => $productos, 'queryString' => $queryString ] );
    }

}
