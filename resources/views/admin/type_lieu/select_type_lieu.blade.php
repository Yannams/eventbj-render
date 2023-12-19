@extends('layout.promoteur')
    @section('content')
        <div class="container mt-5 p-5">
                <ul class="row row-cols-4 row-cols-lg-4 row-cols-md-4 nav nav-pills mb-4" id="pillNav" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{route('select_type_lieu')}}" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                            Type de lieu  
                        </a>
                    </li>          
                    <li class="nav-item" role="presentation">
                        <a href="{{route('evenement.create')}}" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                            Details de l’évènement
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                            Date et heure
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                            Création de ticket 
                        </a>
                    </li>                              
                </ul>

           
            <div class="row align-items-center">
                <form action="{{route('evenement.create')}}" method="get"> 
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                                <div class="col">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        @foreach ($type_lieu as $type_lieus )
                                            <div class="col">
                                                <input type="radio" class="btn-check btn-block" name="type_lieu_event" id="{{$type_lieus->nom_type}}" autocomplete="off" value="{{$type_lieus->id}}">
                                                <label class="btn btn-outline-success w-100" for="{{$type_lieus->nom_type}}">
                                                    <h5>{{$type_lieus->nom_type}}</h5>
                                                    <p>{{$type_lieus->description}}</p>
                                                </label>
                                            </div>          
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <button type="submit" class="btn btn-primary w-100">Suivant</button>
                                </div>
                            </div>
                           
                        </div>    
                    </div>              
                    
                  
                </form>
            </div>
           
        </div>
    @endsection