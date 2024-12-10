@extends('layout.promoteur')
    @section('content')
    <div class="card border-0">
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{route('type_ticket.create')}}" class="btn btn-success text-end"> Ajouter un nouveau ticket</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">prix </th>
                    <th scope="col">Quantité</th>
                    <th scope="col"> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($typeTickets as $type_ticket )
                    <tr>
                        <th scope="row"><img src="{{$type_ticket->image_ticket}}" class="rounded" width="50px" alt=""></th>
                        <td>{{$type_ticket->nom_ticket}}</td>
                        <td>{{$type_ticket->prix_ticket}}</td>
                        <td>{{$type_ticket->place_dispo}}</td>
                        <td class="d-flex align-items-center">
                            <a href="{{route('type_ticket.edit',$type_ticket->id)}}" class="btn btn-success me-2">Modifier</a>
                            <form action="{{route('type_ticket.destroy',$type_ticket->id)}}" method="POST" id="DeleteForm">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger" id="Delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                        
                </tbody>
            </table>
        </div>
    </div>

    @endsection