
@php
use Illuminate\Support\Facades\DB;
@endphp
@php
  $websiteRoot = 'http://localhost:8000'
@endphp

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trinkets And Baubles - @yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/shop-homepage.css')}}" rel="stylesheet">
    <link href="{{asset('css/Supernice.css')}}" rel="stylesheet">

    <!-- master css -->
    <link href={{asset('css/master.css')}} rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">

    <!--Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>


    <!-- Contact form JavaScript -->
    <script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('js/agency.min.js')}}"></script>

  </head>

  <body id="page-top">

<!-- Navegacion -->
  <nav class="navbar navbar-default secondary-navbar">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->

      <div class="row">
      <div class="navbar-header  col-md-2 col-sm-3">
          <div class="navbar-header  col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-3">
            <div class="navbar-brand-container">
              <!--Brand Logo-->
                
              <!--End Brand Logo-->
            </div>

            <!--Navbar toggle icon-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#categories-navbar-menu" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!--End Navbar toggle icon-->
          </div>
        </div>

        <div class="col-md-4 col-sm-8">
          <form class="basic-search-form" >
            <div class="form-group">
              <div class="input-group basic-search-form-group">
                <input type="text" class="form-control" placeholder="Buscar articulo en la tienda..." aria-label="Busqueda" aria-describedby="basic-addon2">
                <div class="input-group-btn">
                  <button class="btn btn-secondary basic-search-form-button"  type="button">Buscar</button>
                </div>
              </div>
            </div>
          </form>        
        </div>

        <div class="col-md-6 col-md-offset-0 col-sm-12 hidden-xs" id="account-nav-container">
          <div class="col-sm-11">
              <ul class="nav navbar-nav navbar-right account-nav ">
                <li class="sell-button">
                  <a href="#">Vender en la tienda</a>
                </li>
                <li class="register-button">
                  <a href="{{$websiteRoot}}/register">Registrarse</a>
                </li>
                <li class="enter-button">
                  <a href="{{$websiteRoot}}/login">Entrar </a>
                </li>
                <li class="shopping-cart-button">
                  <a href="{{$websiteRoot}}/shoping/cart" class="text-center" >
                    <span class="glyphicon glyphicon-shopping-cart" style="font-size: 16px"></span>
                    <br><span class="small-text">Carro</span>
                  </a>
                </li>
              </ul>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
    
    <div class="container-fluid bottom-navbar hidden-xs">
        <div class="collapse navbar-collapse">
          <div class="row bottom-navbar-row">
            <div class="col-sm-10 col-sm-offset-1">
              @php
                $categorias = DB::table('categorias')->get();
              @endphp
              @foreach($categorias as $categoria)
              <div class="col-sm-2">
                <a href="{{$websiteRoot}}/busqueda/categoria/{{$categoria->id}}" class="categories-item-container">
                  <span class="categories-item">{{$categoria->nombre}}</span>
                </a>
              </div>
              @endforeach
            </div>
          </div>
        </div><!-- /.navbar-collapse -->
    </div>

     <div class="container-fluid visible-xs-block" >
      <div  class="collapse navbar-collapse" id="categories-navbar-menu">
        <ul class="nav navbar-nav navbar-right" >
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categorias <span class="caret"></span></a>
            <ul class="dropdown-menu">
              @foreach($categorias as $categoria)
                <li><a href="{{$websiteRoot}}/busqueda/categoria/{{$categoria->id}}">{{$categoria->nombre}}</a></li>  
              @endforeach
            </ul>
          </li>
          <li role="separator" class="divider"></li>
          <li> <a href="#">Vender en la tienda</a></li>
          <li> <a href="/Papw2/Registrase.html">Registrarse</a></li>
          <li> <a href="/Papw2/Entrar.html">Entrar </a></li>
          <li> <a href="#"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 16px"></span><span class="small-text">Carro</span></a></li>
        </ul>
      </div> <!-- /.navbar-collapse -->
    </div>
  </nav>

<!-- Fin de navegacion -->

    <div class="container">
            @yield('content')
    </div>

    <!-- Footer-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Trinkets and Baubles 2018</small>
        </div>
      </div>
    </footer>

    
    
  </body>

</html>
