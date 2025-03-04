@extends('layout.promoteur')
    @section('content')
        
        <ul class="row row-cols-5 row-cols-lg-5 row-cols-md-5 nav nav-pills mb-4 mt-5" id="pillNav" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{route('verificationHistoric',$evenement->id)}}" class="d-flex align-items-center justify-content-center  h-100 fw-bold nav-link rounded @if (!isset($_GET['controleur']) && !isset($_GET['promoteur'])) checked-step @else unchecked-step @endif  me-3" dis role="tab" aria-selected="true" >
                    <span class="d-none d-md-flex"> Tout </span>
                </a>
            </li>         
            
             @foreach ($controleurs as $controleur)
                <li class="nav-item" role="presentation">
                    <a href="{{route('verificationHistoric',['evenement'=>$evenement->id,'controleur'=>$controleur->id])}}"  class=" border-0 d-flex align-items-center justify-content-center h-100 fw-bold nav-link rounded me-3 {{isset($_GET['controleur']) ?($_GET['controleur']==$controleur->id ? "checked-step" : "unchecked-step"): "unchecked-step"}}" role="tab" aria-selected="true" >
                        <span class="d-none d-md-flex"> {{$controleur->ControleurId}} </span>
                    </a>
                </li>   
             @endforeach
                                   
            <li class="nav-item" role="presentation">
                <a href="{{route('verificationHistoric',['evenement'=>$evenement->id,'controleur=promoteur'])}}" class="h-100 d-flex align-items-center justify-content-center fw-bold nav-link rounded {{isset($_GET['controleur']) ?($_GET['controleur']=='promoteur' ? "checked-step" : "unchecked-step"): "unchecked-step"}} me-3" role="tab" aria-selected="true"  >
                     <span class="d-none d-md-flex">Moi-même</span>
                </a>
            </li> 

            
        </ul>
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
                    <th scope="col">Role</th>
                    <th scope="col">statut</th>
                    <th scope="col">Date control</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($verifications as $key=>$verification )
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$verification->ticket_id ? $verification->ticket->user->name : ""}}</td>
                      <td>{{$verification->nom_controleur}}</td>
                      <td>{{$verification->num_controleur}}</td>
                      <td>{{$verification->mail_controleur}}</td>
                      <td>{{$verification->controleur_id ? $verification->controleur->ControleurId : ($verification->profil_promoteur_id ? $verification->profil_promoteur->pseudo : "")}}</td>
                      <td>{{$verification->controleur_id ? "Controleur" : ($verification->profil_promoteur_id ? "Promoteur" : "")}}</td>
                      <td> <span class="p-1 rounded {{$verification->statut=="ticket valide" ? "checked-step" :($verification->statut=="ticket invalide"? "unchecked-step":($verification->statut=="ticket vérifié" ? "checking-step":""))}}">{{$verification->statut}}</span></td>
                      <td>{{date("d/m/Y H:i",strtotime($verification->created_at))}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>

    @endsection
