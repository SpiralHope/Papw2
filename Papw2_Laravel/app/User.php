<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function esAdmin(){
        return $this->role == 'admin';
    }

    public function esVendedor(){
        return $this->role == 'vendedor';
    }

    public function productos(){
        return $this->hasMany('App\Producto', 'id_usuario', 'id');
    }

    public function comentarios(){
        return $this->hasMany('App\Comentario', 'id_usuario', 'id');
    }

    public function ubicacion(){
        return $this->hasOne('App\ShippingInfo', 'id_usuario', 'id');
    }

    public function carrito(){
        return $this->hasMany('App\CarritoDetalle', 'id_usuario', 'id');
    }

}
