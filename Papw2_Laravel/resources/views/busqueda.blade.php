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

@section('title', 'Busqueda')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/datepicker/css/bootstrap-datepicker.css')}}">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('vendor/datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
@endpush

@section('content')
    @if(isset($queryString['revision']) )
    <h2 style="text-align: center;">Productos en revision</h2>
    @elseif(isset($queryString['vendedorId']) )
    <h2 style="text-align: center;">Mis productos @if(isset($queryString['enEdicion'], $queryString['enRevision']) ) en edicion y revision @elseif( isset($queryString['enEdicion']) ) en edicion @elseif( isset($queryString['enRevision'] ))en revision  @endif</h2>
    @else
    <h2 style="text-align: center;">Productos en venta</h2>
    @endif
    

    <section id="productos-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('busqueda') }}" method="GET" style="margin-bottom: 40px">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{isset($queryString['nombre'])?$queryString['nombre'] :''}}" autocomplete="off">
                        </div>    
                        <div class="form-group">
                            <label for="autor">Autor:</label>
                            <input type="text" name="autor" id="autor" class="form-control" value="{{isset($queryString['autor'])?$queryString['autor'] :''}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="despues">Despues de:</label>
                            <input type="text" name="despues" id="despues" class="form-control datepicker" readonly value="{{isset($queryString['despues'])?$queryString['despues'] :''}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="antes">Antes de:</label>
                            <input type="text" name="antes" id="antes" class="form-control datepicker" readonly value="{{isset($queryString['antes'])?$queryString['antes'] :''}}" autocomplete="off">
                        </div>
                         <div class="form-group">
                            <label for="antes">Categorias:</label>
                            <select name="categoria" type="number" class="form-control" autocomplete="off">
                                @if(isset($queryString['categoria']) )
                                    <option value="-1">Todos los productos</option>
                                    @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}" @if($queryString['categoria'] == $categoria->id) selected @endif>{{$categoria->nombre}}</option>
                                    @endforeach
                                @else
                                    <option selected value="-1">Todos los productos</option>
                                    @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        @auth
                            @if(Auth::user()->esAdmin())
                            <div class="form-group">
                                <label for="revision">Solo en Revision</label>
                                <input type="checkbox" id="revision" name="revision" value="true" @if(isset($queryString['revision']) ) checked @endif autocomplete="off">
                            </div>
                            @elseif(Auth::user()->esVendedor())
                                <div class="form-group">
                                    <label for="vendedorId">Mis productos</label>
                                    <input type="checkbox" id="vendedorId" name="vendedorId" value="{{Auth::user()->id}}"  @if(isset($queryString['vendedorId']) ) checked @endif autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="enEdicion">Mis productos en edicion</label>
                                    <input type="checkbox" id="enEdicion" name="enEdicion" value="1" @if(isset($queryString['enEdicion']) ) checked @endif autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="enRevision">Mis productos en revision</label>
                                    <input type="checkbox" id="enRevision" name="enRevision" value="1" @if(isset($queryString['enRevision']) ) checked @endif autocomplete="off">
                                </div>
                            @endif
                        @endauth
                        <script type="text/javascript">
                            $('.datepicker').datepicker({
                                language: 'es'
                            });
                        </script>
                        <button type="submit" class="btn btn-info btn-lg" style="width: 100%"> Buscar</button>
                    </form>    
                </div>
                <div class="col-md-9">
                    <div class="row">
                        @foreach($productos as $producto)
                        @php
                            $producto = App\Producto::find($producto->id);
                            $img = $producto->imagenes()->first();

                            $ranking = $producto->ranking;
                            $comentarios = $producto->comentarios()->orderBy('created_at', 'desc');

                            /* -1; 
                            if($comentarios->count() != 0){
                                $ranking = $comentarios->sum('ranking') / $comentarios->count();
                            }*/

                        @endphp
                        <div class=" col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-0 col-lg-3 col-lg-offset-0 col-md-4 col-md-offset-0">
                            <div class="thumbnail">

                                @if($producto->valid == 1)
                                <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                </a>   
                                @elseif($producto->on_review == 1)
                                    @auth
                                        @if(Auth::user()->esVendedor())
                                        <a href="{{route('verReviewProducto',$producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                        </a>
                                        
                                        @elseif(Auth::user()->esAdmin())
                                        <a href="{{route('verReview',$producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                        </a>
                                        @else 
                                        <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                        </a> 
                                        @endif
                                    @else
                                        <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                        </a>
                                    @endauth

                                @else
                                    @auth
                                        @if(Auth::user()->esVendedor())
                                            <a href="{{route('verEdicionProducto',$producto->id)}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                            </a>
                                        @else
                                            <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{route('producto').'/' .$producto->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
                                        </a>
                                    @endauth

                                @endif

                                <div  style="overflow-y: hidden; height: 120px;">
                                    <img src="{{URL::to('/') . '/' . $img->img_url}}" alt="" class="img-responsive">
                                </div>
                                <div class="caption">
                                    <h4 class="">${{$producto->precio}} MX</h4>
                                    <h4><a href="#">{{$producto->nombre}}</a></h4>
                                    <p>{{$producto->desc_corta}}</p>
                                </div>
                                <div class="ratings">
                                    <p class="pull-right">{{$comentarios->count()}} reseñas</p>
                                    <p>
                                    @for ($i = 0; $i < 5; $i++)
                                        @if($i < $ranking)
                                            <span class="glyphicon glyphicon-star "></span>
                                        @else
                                            <span class="glyphicon glyphicon-star-empty"></span>
                                        @endif
                                    @endfor

                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <nav aria-label="Page navigation example" class="text-center">
      {{ $productos->appends($queryString)->links() }}

    </nav>
@endsection