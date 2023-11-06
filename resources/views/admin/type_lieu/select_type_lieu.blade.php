@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <form action="{{route('evenement.create')}}" method="get">                
                @foreach ($type_lieu as $type_lieus )
                    <input type="radio" name="type_lieu_event" id="type_lieu_event" value="{{$type_lieus->id}}">
                        <div class="card mb-3 col-4">
                            <div class="card-title">{{$type_lieus->nom_type}}</div>
                            <div class="card-body">{{$type_lieus->description}}</div>
                        </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Suivant</button>
            </form>
        </div>
    @endsection