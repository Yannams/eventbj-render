@extends('layout.promoteur')
    @section('content')
    <div class="container my-5">
        @foreach ( $evenements as $evenement)
        <a href="{{route('verificationHistoric',$evenement->id)}}" class="link-underline link-underline-opacity-0 evenementAverifier" >
            <div class="card eventToVerify">
                <div class="card-body">
                    <div class="row ">
                        <div class="d-flex align-items-center row ">
                            <div class="col-6">
                                <img src="{{asset($evenement->cover_event)}}" alt="" width="100%" class="rounded-2">
                            </div>
                            <div class="col-6">
                                {{$evenement->nom_evenement}}
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
      
    
        
    @endsection