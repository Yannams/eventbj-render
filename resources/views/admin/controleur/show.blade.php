@extends('layout.promoteur');
    @section('content')
    @if (session('message'))
    <div class="position-relative">
        <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
            <div id="liveToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <div class="p-2">
                        <svg class="bi bi-check-all" fill="#fff" width="30" height="30">
                            <use xlink:href="#check"></use>
                        </svg>
                    </div>
                    <div class="p-2 fw-bold fs-5">{{session('message')}}</div>
                    <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>    
    </div>
    @elseif (session('danger'))
    <div class="position-relative">
        <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
            <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <div class="p-2">
                        <svg class="bi bi-trash" fill="#fff" width="30" height="30">
                            <use xlink:href="#deleted"></use>
                        </svg>
                    </div>
                    <div class="p-2 fw-bold fs-5">{{session('danger')}}</div>
                    <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>    
    </div>
    @elseif (session('error'))
    <div class="position-relative">
        <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
            <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <div class="p-2">
                        <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                            <use xlink:href="#error"></use>
                        </svg>
                    </div>
                    <div class="p-2 fw-bold fs-5">{{session('error')}}</div>
                    <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>    
    </div>
    @endif
        <div class="d-flex justify-content-end align-items-center mb-5">
            <a href="{{route('controleur.edit',$controleur)}}" class="btn btn-success">Ajouter un nouveau controleur pour ce compte</a>
        </div>
        @foreach ($controleur->evenements as $controleur_evenement )
            <div class="card border-0 shadow mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-success " data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('editControl',['controleur'=>$controleur_evenement->pivot->controleur_id,'evenement'=>$controleur_evenement->pivot->evenement_id])}}" class=" dropdown-item">Modifier</a>
                            </li>
                            <li>
                                @if ($controleur_evenement->pivot->statut=="activé")
                                    <a href="{{route('executeDesactivation',['controleur'=>$controleur_evenement->pivot->controleur_id,'evenement'=>$controleur_evenement->pivot->evenement_id] )}}" class=" dropdown-item">Désactiver le controle</a>
                                @else
                                    <a href="{{route('activerControl',['controleur'=>$controleur_evenement->pivot->controleur_id,'evenement'=>$controleur_evenement->pivot->evenement_id])}}" class=" dropdown-item">Activer le controle</a>
                                @endif
                            </li>
                            <li>
                                <a href="{{route('ControlHistoric',['controleur'=>$controleur_evenement->pivot->controleur_id,'evenement'=>$controleur_evenement->pivot->evenement_id])}}" class=" dropdown-item">Voir l'historique du controle</a>
                            </li>
                           
                        </ul>
                    </div>
                  
                    <div class="d-md-flex ">
                        <div class="rounded me-5 my-3" style="background-image: url('{{asset($controleur_evenement->cover_event)}}'); background-size: cover; width:300px; height: 150px;" ></div>
                        <div>
                            <div class="fs-3 fw-bold">{{$controleur_evenement->nom_evenement}}</div>
                            <div class="mb-2">
                                @if ($controleur_evenement->date_heure_debut>=now())
                                    <i class="bi bi-circle-fill text-warning me-2" style="font-size: 10px" ></i> <span class="text-warning fw-bold"> Evènement pas encore commencé</span>
                                @elseif ($controleur_evenement->date_heure_debut<=now() && $controleur_evenement->date_heure_fin>=now())
                                    <i class="bi bi-circle-fill text-success me-2" style="font-size: 10px" ></i> <span class="text-success fw-bold"> Evènement en cours</span>
                                @elseif ($controleur_evenement->date_heure_fin<=now())
                                    <i class="bi bi-circle-fill text-danger me-2" style="font-size: 10px" ></i> <span class="text-danger fw-bold"> Evènement Terminé </span>
                                @endif
                            </div>
                            <div class="mb-4">{{date('d/m/Y à H:i', strtotime($controleur_evenement->date_heure_debut))}} - {{date('d/m/Y à H:i',strtotime( $controleur_evenement->date_heure_fin))}}</div>
                            <div class="mb-2">Nom du controleur: <span class="fw-bold"> {{ $controleur_evenement->pivot->name}}</span></div>
                            <div class="mb-2" >Nombre de controle effectué: 100</div>
                            @if ($controleur_evenement->pivot->statut=="activé")
                                <i class="bi bi-circle-fill text-success me-2" style="font-size: 10px" ></i> <span class="text-success fw-bold">Activé</span>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
        @endforeach
        <script>
              document.addEventListener('DOMContentLoaded', function () {
                const toastLiveExample = document.getElementById('liveToast');
                if (toastLiveExample) {
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                    toastBootstrap.show();
                }
            });
        </script>
    @endsection