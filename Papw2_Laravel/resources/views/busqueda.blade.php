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
                            for ($i=0; $i < 20; $i++) { 
                               $thumbs[$i] = (object) ['id' => '1', 'img' => 'img/cool1.jpg','precio' => '250', 'nombre' => 'Pintura Cool', 'descripcion' => 'descripciooooon', 'totalReviews' => '12', 'ranking' => '3'];
                                # code...
                            }
                           
                        @endphp
                        @each('prodThumb', $thumbs, 'thumb')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <nav aria-label="Page navigation example" class="text-center">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link"  tabindex="-1">Anterior</a>
        </li>
        <li class="page-item active"><a class="page-link" href="">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link">...</a></li>
        <li class="page-item"><a class="page-link" href="#">8</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Siguiente</a>
        </li>
      </ul>
    </nav>
@endsection