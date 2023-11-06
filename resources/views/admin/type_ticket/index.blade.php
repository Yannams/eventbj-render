@extends('layout.promoteur')
    @section('content')
    <div class="container">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{route('type ticket.create')}}" class="btn btn-primary text-end"> Ajouter un nouveau ticket</a>
      </div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">prix </th>
                <th scope="col">Quantité</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($typeTickets as $type_ticket )
                <tr>
                    <th scope="row"><img src="{{$type_ticket->image_ticket}}" class="rounded" width="50px" alt=""></th>
                    <td>{{$type_ticket->nom_ticket}}</td>
                    <td>{{$type_ticket->prix_ticket}}</td>
                    <td>{{$type_ticket->place_dispo}}</td>
                </tr>
                @endforeach
                   
            </tbody>
          </table>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{route('MesEvenements')}}" class="btn btn-primary text-end">Suivant</a>
          </div>
       
    </div>
      @endsection