@extends('layout.utilisateur')
    @section('content')
      <div class="container my-3">
        @foreach ($ticket as $tickets)
        <div class="row">
          
              <div class="badge badge-tool text-dark shadow col-4"><span class="fs-3">{{date('d',strtotime($tickets->type_ticket->evenement->date_heure_debut))}}</span><br><span>{{date('M',strtotime($tickets->type_ticket->evenement->date_heure_debut))}}</span></div>
              <div class="card shadow mb-3 border-0 col-8 m-5" style="max-width: 540px;">
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-4 col-12 rounded-3" style="background-image: url('{{asset($tickets->type_ticket->image_ticket)}}'); background-size: cover;">
                          <br>
                          <br>
                          <br>
                          <br> 
                          <br>
                        </div>
                        <div class="col-md-4 fw-bold">
                            {{$tickets->type_ticket->evenement->nom_evenement}}
                        </div>
                        <div class="card-text col-md-4 fw-bold"  style="color: @if(new DateTime($tickets->type_ticket->evenement->date_heure_fin)<= new DateTime()) #F0343C @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut)<= new DateTime() && new DateTime($tickets->type_ticket->evenement->date_heure_fin)>= new DateTime()) #FBAA0A @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut) > new DateTime()) #308747  @endif">  @if(new DateTime($tickets->type_ticket->evenement->date_heure_fin)<= new DateTime(now())) Terminé @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut)<= new DateTime() && new DateTime($tickets->type_ticket->evenement->date_heure_fin)>= new DateTime()) en cours @elseif(new DateTime($tickets->type_ticket->evenement->date_heure_debut) > new DateTime()) A venir @endif </div>
                    </div>
                    <div class="w-100"><a href="{{route('downloadTicket',$tickets->id)}}" class="btn btn-success w-100 mt-3"><svg class="bi bi-download" fill="currentColor"  width="16" height="16"><use xlink:href="#download"></use></svg> Télécharger</a></div>
                </div> 
                
            </div>
        @endforeach
      </div>
    @endsection