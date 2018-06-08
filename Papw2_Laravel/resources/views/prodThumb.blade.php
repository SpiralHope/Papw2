
<div class="col-sm-4 col-lg-3 col-md-3">
    <div class="thumbnail">
        <a href="http://localhost:8000/producto/details/{{$thumb->id}}" style="width: 100%; height: 100%; display: block; position: absolute; top: 0px; left: 0px">
        </a>      
        <div  style="overflow-y: hidden; height: 120px;">
            <img src="http://localhost:8000/{{$thumb->img}}" alt="" class="img-responsive">
        </div>
        <div class="caption">
            <h4 class="pull-right">${{$thumb->precio}} MX</h4>
            <h4><a href="#">{{$thumb->nombre}}</a></h4>
            <p>{{$thumb->descripcion}}</p>
        </div>
        <div class="ratings">
            <p class="pull-right">{{$thumb->totalReviews}} reseñas</p>
            <p>
                @for ($i = 0; $i < $thumb->ranking; $i++)
                    <span class="glyphicon glyphicon-star"></span>
                @endfor
                @for ($i = 0; $i < 5 - $thumb->ranking; $i++)
                    <span class="glyphicon glyphicon-star-empty"></span>
                @endfor
            </p>
        </div>
    </div>
</div>

