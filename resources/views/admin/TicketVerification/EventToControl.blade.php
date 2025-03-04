@extends('layout.promoteur')
    @section('content')
        @foreach ( $evenements as $evenement)
        <a href="{{route('verificationHistoric',$evenement->id)}}" class="link-underline link-underline-opacity-0 evenementAverifier" >
            <div class="card eventToVerify">
                <div class="card-body">
                    <div class="row ">
                        <div class="d-flex align-items-center">
                            <div class="col-3">
                                <img src="{{asset($evenement->cover_event)}}" alt="" width="100px" class="rounded-2">
                            </div>
                            <div class="col-3">
                                {{$evenement->nom_evenement}}
                            </div>
                            <div class="col-3">
                                {{date('d/m/Y', strtotime($evenement->date_heure_debut))}}
                            </div>
                            <div class="col-3">
                                {{date('d/m/Y', strtotime($evenement->date_heure_fin))}}
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    
        
    @endsection