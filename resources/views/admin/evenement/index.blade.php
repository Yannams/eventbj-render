@extends('layout.utilisateur')
    @section('content')
    <div class="row row-cols-1 row-cols-md-3 g-3 mb-5" >
          <div class="col">
            <div class="card rounded-4 border-0" style="width: 18rem; background-color:#F0343C;">
                <img src="{{asset('image/img.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                <div class="card-body">
                    <h5 class="card-title fw-bold">ZECHILL</h5>
                    <p class="card-text"><span></span>22/12/23</p>
                </div>
                <div class="card-body text-end">
                     <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Obtenir tickets</b></a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card rounded-4 border-0" style="width: 18rem; background-color:#FBAA0A;">
                <img src="{{asset('image/Capture d’écran 2023-08-10 170824.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="max-width: 70%;" alt="...">
                <div class="card-body">
                    <h5 class="card-title fw-bold">ZECHILL</h5>
                    <p class="card-text"><span></span>22/12/23</p>
                </div>
                <div class="card-body text-end">
                     <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Obtenir tickets</b></a>
                </div>
            </div>
        </div>
         <div class="col">
            <div class="card rounded-4 border-0" style="width: 18rem; background-color:#308747;">
                <img src="{{asset('image/Capture d’écran 2023-08-10 172019.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                <div class="card-body">
                    <h5 class="card-title fw-bold">ZECHILL</h5>
                    <p class="card-text"><span></span>22/12/23</p>
                </div>
                <div class="card-body text-end">
                     <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Obtenir tickets</b></a>
                </div>
            </div>
        </div>
    </div>
    
    
    @foreach ($type_evenement as $key => $type_evenements )
        @if($key === 0)
            <a href="{{route('evenement.index')}}"><span class="badge rounded-pill text-bg-success">{{$type_evenements->nom_type_evenement}}</span></a>
        @else
            <a href="{{route('type_event', ['type'=>$type_evenements->id])}}"><span class="badge rounded-pill text-black border border-success">{{$type_evenements->nom_type_evenement}}</span></a>
        @endif
    @endforeach

 
    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
        @foreach ( $evenement as $evenements )
        <a href="{{route('evenement.show', ['evenement'=>$evenements->id])}}" class="link-dark  link-offset-2 link-underline link-underline-opacity-0">
            <div class="col">
                <div class="card card-cover overflow-hidden text-bg-dark rouded-4 shadow-lg " style="background-image: url('{{asset($evenements->cover_event)}}'); padding-bottom:200px">        
                </div>
                <div class="fw-bold fs-4" >{{$evenements->nom_evenement}} </div>
            </div></a>
          
        @endforeach
    </div>
        
    
       
    @endsection 