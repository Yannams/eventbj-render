@extends('layout.promoteur')
    @section('content')
        @foreach ( auth()->user()->evenements as $evenement )
            <div class="fs-2 fw-bold">{{$evenement->nom_evenement}}</div>
            <div class="card border-0 shadow ms-md-5 my-3">
                <div class="card-body">
                   <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">prix </th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Date et heure de Lancement</th>
                            <th scope="col">Date et heure de fermeture</th>
                            <th scope="col"> Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($evenement->type_tickets as $type_ticket )
                            <tr>
                                <th scope="row"><img src="{{$type_ticket->image_ticket}}" class="rounded" width="50px" alt=""></th>
                                <td>{{$type_ticket->nom_ticket}}</td>
                                <td>{{$type_ticket->prix_ticket}}</td>
                                <td>{{$type_ticket->place_dispo}}</td>
                                <td>{{$type_ticket->Date_heure_lancement!=null ?date('d/m/Y H:i', strtotime($type_ticket->Date_heure_lancement)):"A programmer"}}</td>
                                <td>{{$type_ticket->Date_heure_fermeture!=null ?date('d/m/Y H:i', strtotime($type_ticket->Date_heure_fermeture)):"A programmer"}}</td>

                                <td>
                                    <a href="{{route('type_ticket.edit',$type_ticket->id)}}" class="btn btn-success">Modifier</a>
                                </td>
                            </tr>
                            @endforeach
                               
                        </tbody>
                    </table>
                   </div>
                </div>
            </div>
        @endforeach
    @endsection