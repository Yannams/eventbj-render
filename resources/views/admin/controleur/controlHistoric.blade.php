@extends('layout.promoteur')
    @section("content")
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">nom participant</th>
                            <th scope="col">nom controleur</th>
                            <th scope="col">numero controleur</th>
                            <th scope="col">email controleur</th>
                            <th scope="col">Compte controleur</th>
                            <th scope="col">statut</th>
                            <th scope="col">Date control</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($ticketsControleur as $key=>$ticketControleur )
                            <tr>
                              <th scope="row">{{$key+1}}</th>
                              <td>{{$ticketControleur->ticket_id ? $ticketControleur->ticket->user->name : ""}}</td>
                              <td>{{$ticketControleur->nom_controleur}}</td>
                              <td>{{$ticketControleur->num_controleur}}</td>
                              <td>{{$ticketControleur->mail_controleur}}</td>
                              <td>{{$ticketControleur->controleur->ControleurId}}</td>
                              <td> <span class="p-1 rounded {{$ticketControleur->statut=="ticket valide" ? "checked-step" :($ticketControleur->statut=="ticket invalide"? "unchecked-step":($ticketControleur->statut=="ticket vérifié" ? "checking-step":""))}}">{{$ticketControleur->statut}}</span></td>
                              <td>{{date("d/m/Y H:i",strtotime(datetime: $ticketControleur->created_at))}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    @endsection