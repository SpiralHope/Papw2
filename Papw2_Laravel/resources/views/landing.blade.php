@php

    use App\Producto;
    use App\User;
    use App\Comentario;
    use App\Categoria;

    use App\CarritoDetalle;
    use Carbon\Carbon;

    $categorias = App\Categoria::all();

@endphp


@extends('master')

@section('title', 'Landing')

@section('content')

@push('styles')
        <style type="text/css">
            .productos-item img{
              width: 100%;
            }

            .producto-preview{
              width: 100%;
              position: relative;
              height: 160px;
              border: 2px solid #b1c7d4;
              border-radius: 5px;
              background-color: #75a6c2;
              overflow: hidden;
              color: white;
            }

            .producto-preview-anchor{
              display: block;
              width: 100%;
              height: 100%;
              position: absolute;
              top: 0px;
              left: 0px;
            }

            .producto-preview-img{
              width: 100%;
              height: 120px;
              overflow: hidden;
            }

            .producto-preview-img img{
              width: 100%;
            }

            .producto-preview-nombre{
              width: 100%;
              height: 40px;
              padding: 8px 0px;
              text-align: center;
            }

            .producto-preview-nombre span{
              display: block;
            }

        </style>
@endpush

<div style="height: 40px"></div>

    <section id="nosotros-container">
      <div class="container">
        <div class="row text-center">
          <div class="col-sm-4 col-sm-offset-0 col-xs-8 col-xs-offset-2">
            
            <h4 class="nosotros-heading">Creatividad</h4>
            <p class="text-muted">Encuentra productos ofrecidos directamente por los mismos creadores. Veras una calidad de productos diseñados con un cuidado y calidad que solo veras aqui.</p>
          </div>
          <div class="col-sm-4 hidden-xs">
            <h4 class="nosotros-heading">Variedad</h4>
            <p class="text-muted">Gracias a la cantidad de artistas y vendedores que se unen cada dia a nuestro sitio, podras encontrar de todo. Ademas, tenemos distintas categorias para que encuentres lo que busques de manera veloz.</p>
          </div>
          <div class="col-sm-4 hidden-xs">
            <h4 class="nosotros-heading">Facil y Rapido</h4>
            <p class="text-muted">En solo unos clicks podras agregar a tu carrito los productos que gustes. Asi de facil tambien puedes empezar a vender tus productos en nuestra tienda.</p>
          </div>
        </div>
      </div>
    </section>

<div style="height: 40px"></div>
    <h2 style="text-align: center;">Categorias</h2>
    <section id="productos-container">
      <div class="container">
        <div class="row">

         @foreach( $categorias as $categoria)
            <div class="col-md-2 col-xs-4 ">
              
              <div class="producto-preview">
                @php
                  $producto = App\Producto::where('id_categoria', $categoria->id)->where('valid', 1);
                @endphp
                @if($producto->count()>0)
                  @php
                    $producto = $producto->orderBy('ranking', 'desc');
                    $producto = $producto->first();
                    $img = $producto->imagenes()->first();
                  @endphp
                <a href="{{route('producto').'/' .$producto->id}}" class="producto-preview-anchor">

                </a>
                <div class="producto-preview-img">
                  <img src="{{URL::to('/') . '/' . $img->img_url}}" >
                </div>
                <div class="producto-preview-nombre">
                  <span>{{$categoria->nombre}}</span>
                </div>
                @endif
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </section>

    <div style="height: 40px"></div>
    <div class="container-fluid" style="background-color: #305f7a; 
  padding: 30px 0px 40px 0px;">
      <a class="abre-tienda" href="#">
        <h2 style="text-align: center;">Empiece a vender con nosotros</h2>
        <h4 style="text-align: center;">Unase a las miles de personas que confian en nuestra plataforma</h4>
        <h4 class="link" style="text-align: center;">Crea tu tienda hoy</h4>
      </a>
    </div>

    <div style="height: 40px"></div>
    <h2 style="text-align: center;">Populares</h2>
    <div style="height: 40px"></div>
    <section id="productos-container">
      <div class="container">
        <div class="row">

           @foreach( $categorias as $categoria)
            <div class="col-md-2 col-xs-4 ">
              
              <div class="producto-preview">
                @php
                  $producto = App\Producto::where('id_categoria', $categoria->id)->where('valid', 1);
                @endphp
                @if($producto->count()>0)
                  @php
                    $producto = $producto->orderBy('reviews', 'desc');
                    $producto = $producto->first();
                    $img = $producto->imagenes()->first();
                  @endphp
                <a href="{{route('producto').'/' .$producto->id}}" class="producto-preview-anchor">

                </a>
                <div class="producto-preview-img">
                  <img src="{{URL::to('/') . '/' . $img->img_url}}" >
                </div>
                <div class="producto-preview-nombre">
                  <span>{{$categoria->nombre}}</span>
                </div>
                @endif
              </div>
            </div>
          @endforeach
          

        </div>


        </div>
      </div>
    </section>


@endsection