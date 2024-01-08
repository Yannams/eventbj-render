@extends('layout.promoteur')
    @section('content')
    @include('layout.stepform')
  
        <div class="row align-items-center">
            <form action="{{route('evenement.store')}}" method="post"> 
                @csrf
              
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                            <div class="col">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        <div class="col">
                                            <input type="radio" class="btn-check btn-block" name="Fréquence" id="unique" autocomplete="off" value="unique">
                                            <label class="btn btn-outline-success w-100" for="unique">
                                                <h5>Une seule fois</h5>
                                                <p>Evenement qui se produit une seule fois </p>
                                            </label>
                                        </div>      
                                        <div class="col">
                                            <input type="radio" class="btn-check btn-block" name="Fréquence" id="multiple" autocomplete="off" value="multiple">
                                            <label class="btn btn-outline-success w-100" for="multiple">
                                                <h5>Plusieurs fois</h5>
                                                <p>Evenement qui se produit plusieurs fois avec plusieurs éditions</p>
                                            </label>
                                        </div>          
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success w-100">Suivant</button>
                            </div>
                        </div>              
                    </div>    
                </div>                  
            </form>
        </div>
    @endsection