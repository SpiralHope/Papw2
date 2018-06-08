<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoImg extends Model
{
    //
    use softDeletes;

    public function producto(){
    	return $this->belongsTo('App\ProductoImg', 'id_producto', 'id');
    }
}
