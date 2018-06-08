<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    //
    use softDeletes;

    public function carritoDetalles(){
        return $this->hasMany('App\CarritoDetalle', 'id_producto', 'id');
    }

    public function categoria(){
    	return $this->belongsTo('App\Categoria', 'id_categoria', 'id');
    }

    public function usuario(){
    	return $this->belongsTo('App\User', 'id_usuario', 'id');
    }

    public function imagenes(){
    	return $this->hasMany('App\ProductoImg', 'id_producto', 'id');
    }

 	public function comentarios(){
    	return $this->hasMany('App\Comentario', 'id_producto', 'id');
    }

    

}
