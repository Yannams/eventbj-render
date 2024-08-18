@extends('layout.Admin')
    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom </th>
                            <th scope="col">Mail </th>
                            <th scope="col">Numero </th>
                            <th scope="col">Role</th>
                            <th scope="col">Options</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key=>$user )
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->num_user}}</td>
                                    <td>{{$user->roles->first()->name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </a>
                                          
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{route('UserActivity',$user->id)}}">Voir les activités</a></li>
                                              <li><button class="dropdown-item">Retirer le role promoteur</button></li>
                                              <li><button class="dropdown-item">Bloquer les possibilités d'achat</button></li>
                                            </ul>
                                        </div>
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