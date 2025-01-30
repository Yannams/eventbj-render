@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Catégorie</th>
                                    <th scope="col">Format</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($participants as $key=>$participant )
                                    <tr>
                                        <th scope="row">{{$key+1}}</th>
                                        <td>{{$participant->name}}</td>
                                        <td>
                                            @foreach ($participant->tickets as $ticket )
                                                @if ($ticket->type_ticket->evenement_id==$evenement_id)
                                                    {{$ticket->type_ticket->nom_ticket}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($participant->tickets as $ticket )
                                            @if ($ticket->type_ticket->evenement_id==$evenement_id)
                                                {{$ticket->type_ticket->format}}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-success">Rembourser</a>
                                            
                    
                                        </td>
                                    </tr>    
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection