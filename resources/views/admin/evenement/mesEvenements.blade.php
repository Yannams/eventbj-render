@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom évènement</th>
                    <th scope="col">En ligne </th>
                    <th scope="col">Date début</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                @foreach ($evenement as $evenements )
                <tr>
                    <th scope="row"><img src="{{asset($evenements->cover_event)}}" alt="" width="100" class="rounded"></th>
                    <td>{{$evenements->nom_evenement}}</td>
                    <td>@if ( $evenements->isOnline==false )
                      non-publié
                    @else
                      en ligne
                    @endif</td>
                    <td>{{$evenements->date_heure_debut}}</td>
                    <td>
                      <a href="" class="btn btn-secondary">gérer</a>
                      <form action="{{route('OnlineEvents', ['evenement'=>$evenements->id])}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Mettre en ligne</button>
                      </form>
                      <a href="" class="btn btn-primary">Modifier l'évènement</a>
                      <a href="" class="btn btn-danger">Supprimer</a>
                    </td>

                  </tr> 
                @endforeach
                 
                </tbody>
              </table>
        </div>
    @endsection