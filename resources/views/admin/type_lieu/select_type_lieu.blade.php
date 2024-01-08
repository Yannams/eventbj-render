@extends('layout.promoteur')
    @section('content')
    @include('layout.stepform');
            <div class="row align-items-center">
                <form action="{{route('typelieuSelected')}}" method="post">
                    @csrf 
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                                <div class="col">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        @foreach ($type_lieu as  $type_lieus )
                                        <div class="col">
                                            <input type="radio" class="btn-check" name="type_lieu_event" id="{{$type_lieus->nom_type}}"  value="{{$type_lieus->id}}" autocomplete="off" checked>
                                            <label class="btn w-100 h-100" for="{{$type_lieus->nom_type}}">
                                                <h5>{{$type_lieus->nom_type}}</h5>
                                                <p>{{$type_lieus->description}}</p>
                                            </label>
                                        </div>    
                                    @endforeach
                                    </div>
                                </div>
                                {{-- <div class="visually-hidden">
                                    <input type="hidden" name="" value="{{$evenement_id}}">
                                </div>  --}}
                                <div class="col">
                                    <button type="submit" class="btn btn-success w-100">Suivant</button>
                                </div>
                            </div>
                           
                        </div>    
                    </div>              
                    
                  
                </form>
            </div>
           
    @endsection