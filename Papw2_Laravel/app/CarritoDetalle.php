<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarritoDetalle extends Model
{
    //
	public function producto(){
		return $this->belongsTo('App\Producto', 'id_producto', 'id');
	}

	public function usuario(){
    	return $this->belongsTo('App\User', 'id_usuario', 'id');
    }

}
