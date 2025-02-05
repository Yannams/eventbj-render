@extends('layout.promoteur');
    @section('content')
        <div class="d-flex justify-content-end align-items-center mb-5">
            <a href="{{route('controleur.edit',$controleur)}}" class="btn btn-success">Ajouter un nouveau controleur pour ce compte</a>
        </div>
        @foreach ($controleur->evenements as $controleur_evenement )
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center">
                       <a href="" class="btn btn-success">Voir les activités de controle</a>
                    </div>
                  
                    <div class="d-md-flex ">
                        <div class="rounded me-5 my-3" style="background-image: url('{{asset($controleur_evenement->cover_event)}}'); background-size: cover; width:300px; height: 150px;" ></div>
                        <div>
                            <div class="fs-3 fw-bold">{{$controleur_evenement->nom_evenement}}</div>
                            <div class="mb-2">
                                @if ($controleur_evenement->date_heure_debut>=now())
                                    <i class="bi bi-circle-fill text-warning me-2" style="font-size: 10px" ></i> <span class="text-warning fw-bold"> En attente</span>
                                @elseif ($controleur_evenement->date_heure_debut<=now() && $controleur_evenement->date_heure_fin>=now())
                                    <i class="bi bi-circle-fill text-success me-2" style="font-size: 10px" ></i> <span class="text-warning fw-bold"> En cours</span>
                                @elseif ($controleur_evenement->date_heure_fin<=now())
                                    <i class="bi bi-circle-fill text-success me-2" style="font-size: 10px" ></i> <span class="text-warning fw-bold"> Terminé
                                        
                                    </span>

                                @endif
                            </div>
                            <div class="mb-4">{{date('d/m/Y à H:i', strtotime($controleur_evenement->date_heure_debut))}} - {{date('d/m/Y à H:i',strtotime( $controleur_evenement->date_heure_fin))}}</div>
                            <div class="mb-2">Nom du controleur: <span class="fw-bold"> {{ $controleur_evenement->pivot->name}}</span></div>
                            <div >Nombre de controle effectué: 100</div>
                        </div>
                    </div>  
                </div>
            </div>
        @endforeach
    @endsection