@extends('master')

@section('title', 'Busqueda')

@section('content')
    <h2 style="text-align: center;">Productos en venta</h2>
    <section id="productos-container">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @php
                            $thumbs = array();
                            $thumbs[0] = (object) ['id' => '1', 'img' => 'img/cool1.jpg','precio' => '250', 'nombre' => 'Pintura Cool', 'descripcion' => 'descripciooooon', 'totalReviews' => '12', 'ranking' => '3'];
                            $thumbs[1] = (object) ['id' => '1', 'img' => 'img/cool1.jpg','precio' => '250', 'nombre' => 'Pintura Cool', 'descripcion' => 'descripciooooon', 'totalReviews' => '12', 'ranking' => '3'];
                            $thumbs[2] = (object) ['id' => '1', 'img' => 'img/cool1.jpg','precio' => '250', 'nombre' => 'Pintura Cool', 'descripcion' => 'descripciooooon', 'totalReviews' => '12', 'ranking' => '3'];
                        @endphp
                        @each('prodThumb', $thumbs, 'thumb')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection