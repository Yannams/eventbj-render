@extends('layout.utilisateur')
    @section('content')
  
    @foreach ($type_evenement as $key => $type_evenements )
        @if($key === 0)
            <a href="{{route('evenement.index')}}"><span class="badge rounded-pill text-bg-success">{{$type_evenements->nom_type_evenement}}</span></a>
        @else
            <a href="{{route('type_event', ['type'=>$type_evenements->id])}}"><span class="badge rounded-pill text-black border border-success">{{$type_evenements->nom_type_evenement}}</span></a>
        @endif
    @endforeach

 
    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
        @foreach ( $evenement as $evenements )
        <a href="{{route('evenement.show', ['evenement'=>$evenements->id])}}">
            <div class="col">
                <div class="card card-cover overflow-hidden text-bg-dark rouded-4 shadow-lg " style="background-image: url('{{asset($evenements->cover_event)}}'); padding-bottom:200px">        
                </div>
                <div>{{$evenements->nom_evenement}}
            </div>
            </div></a>
          
        @endforeach
    </div>
        
    
       
    @endsection 