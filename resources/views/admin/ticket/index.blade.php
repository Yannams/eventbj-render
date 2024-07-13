@extends('layout.utilisateur')
    @section('content')
        @foreach ($ticket as $tickets)
        <div class="row">
        
            <div class="badge badge-tool text-dark shadow col-4"><span class="fs-3">{{date('d',strtotime($tickets->type_ticket->evenement->date_heure_debut))}}</span><br><span>{{date('M',strtotime($tickets->type_ticket->evenement->date_heure_debut))}}</span></div>
            <div class="card shadow mb-3 border-0 col-8 m-5" style="max-width: 540px;">
                <div class="d-flex align-items-center">
                  <div class="p-2 w-25">
                    <img src="{{asset($tickets->code_QR)}}" class="img-fluid rounded-4 m-3" alt="..."  width="100px">
                  </div>
                  <div class="p-2">
                    <div class="card-body row">
                      <p class="card-text col-6 fw-bold">{{$tickets->type_ticket->evenement->nom_evenement}}</p>
                      <p class="card-text col-4 fw-bold"  style="color: @if(new DateTime($tickets->type_ticket->evenement->date_heure_fin)<= new DateTime()) #F0343C @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut)<= new DateTime() && new DateTime($tickets->type_ticket->evenement->date_heure_fin)>= new DateTime()) #FBAA0A @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut) > new DateTime()) #308747  @endif">  @if(new DateTime($tickets->type_ticket->evenement->date_heure_fin)<= new DateTime()) Terminé @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut)<= new DateTime() && new DateTime($tickets->type_ticket->evenement->date_heure_fin)>= new DateTime()) en cours @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut) > new DateTime()) A venir @endif </p>
                      <div class="col-2"> <svg class="bi bi-download" fill="currentColor"  width="16" height="16"><use xlink:href="#download"></use></svg></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        @endforeach
    @endsection