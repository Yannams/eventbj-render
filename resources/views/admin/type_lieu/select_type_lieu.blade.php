@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <div class="row align-items-center">
                <form action="{{route('evenement.create')}}" method="get">  
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                        @foreach ($type_lieu as $type_lieus )
                            <div class="col">
                                <input type="radio" class="btn-check" name="type_lieu_event" id="{{$type_lieus->nom_type}}" autocomplete="off" value="{{$type_lieus->id}}">
                                <label class="btn btn-outline-success" for="{{$type_lieus->nom_type}}">
                                    <h5>{{$type_lieus->nom_type}}</h5>
                                    <p>{{$type_lieus->description}}</p>
                                </label>
                            </div>          
                        @endforeach
                    </div>              
                    
                    <button type="submit" class="btn btn-primary">Suivant</button>
                </form>
            </div>
           
        </div>
    @endsection