
@extends('layout.promoteur')
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
        <ul class="row row-cols-4 row-cols-lg-4 row-cols-md-4 nav nav-pills mb-4" id="pillNav" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{route('select_type_lieu')}}" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
                    Type de lieu  
                </a>
            </li>          
            <li class="nav-item" role="presentation">
                <a href="{{route('evenement.create')}}" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
                    Details de l’évènement
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                    Date et heure
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                    Création de ticket 
                </a>
            </li>                              
        </ul>
            <div class="card border-0">
                <div class="card-body">
                    <form action="{{route('updateHours',$evenement)}}" method="post" id="updateHours">
                        @csrf
                        
                        <div class="col-12 mb-3">
                            <label for="date_heure_debut">Date et heure de début</label>
                            <input type="datetime-local" name="date_heure_debut" id="date_heure_debut" class="form-control" value="{{$evenement->date_heure_debut}}" >
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="date_heure_fin">Date et heure de fin</label>
                            <input type="datetime-local" name="date_heure_fin" id="date_heure_fin" class="form-control" value="{{$evenement->date_heure_fin}}">
                        </div>
                    </form>
                    <form action="{{route('chronogramme.store')}}" method="post">
                        @csrf
        
        
                        <input type="hidden" name="evenement_id" value="{{$evenement_id}}">
                        <div class="d-flex mb-4">
                            <div class="p-2 w-100 fw-bold">Ajouter un chronogramme</div>
                            <div class="p-2">
                                <a class="btn" data-bs-toggle="collapse" href="#date_activite_fields" role="button" aria-expanded="false" aria-controls="chronogramme" id="">
                                    <svg class="bi bi-plus" fill="#F0343C" width="30" height="30">
                                        <use xlink:href="#plus"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>                
                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <div id="date_activite_fields" class="collapse" >
                                                    
                                    </div>
                                </div>
                            </div>
                        <script>
                            var date_heure_debutInput = document.getElementById('date_heure_debut')
                            var date_heure_finInput = document.getElementById('date_heure_fin')
                            if (date_heure_debutInput.value != "" && date_heure_finInput.value != ""){
                                generateDateFields();
                            }
            
                    
                            document.getElementById('date_heure_debut').addEventListener('input', function () {
                                generateDateFields();
                            });
                        
                            document.getElementById('date_heure_fin').addEventListener('input', function () {
                                generateDateFields();
                            });

                            function generateDateFields() {
                                
                        

                                $.ajax({
                                        url: '{{route("updateHours",$evenement)}}',
                                        type: 'POST',
                                        data: {
                                            // Données à envoyer avec la requête
                                            date_heure_debut:  date_heure_debutInput.value,
                                            date_heure_fin: date_heure_finInput.value
                                        },
                                        success: function(response) {
                                            // Traitement de la réponse du serveur
                                            // console.log(response);
                                        },
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        error: function(error) {
                                            // Gestion des erreurs
                                            // console.log(error);
                                        }
                                    });

                            }
                        
                        </script>
                        
                        {{-- <script>
                            var date_heure_debutInput = document.getElementById('date_heure_debut')
                            var date_heure_finInput = document.getElementById('date_heure_fin')
                            if (date_heure_debutInput.value != "" && date_heure_finInput.value != ""){
                                generateDateFields();
                            }
            
                    
                            document.getElementById('date_heure_debut').addEventListener('input', function () {
                                generateDateFields();
                            });
                        
                            document.getElementById('date_heure_fin').addEventListener('input', function () {
                                generateDateFields();
                            });
                        
                            function generateDateFields() {
                                // Exemple avec jQuery
                                    $.ajax({
                                        url: '/traiter-requete-ajax',
                                        type: 'POST',
                                        data: {
                                            // Données à envoyer avec la requête
                                            date_heure_debut: 'valeur1',
                                            date_heure_fin: 'valeur2'
                                        },
                                        success: function(response) {
                                            // Traitement de la réponse du serveur
                                          
                                        },
                                        error: function(error) {
                                            // Gestion des erreurs
                                          
                                        }
                                    });

                                var dateDebut = new Date(document.getElementById('date_heure_debut').value);
                                var dateFin = new Date(document.getElementById('date_heure_fin').value);
                                var dateActiviteFields = document.getElementById('date_activite_fields');
                        
                                dateActiviteFields.innerHTML = ''; // Nettoyer le contenu existant
                        
                                while (dateDebut <= dateFin) {
                                    var dateActiviteField = document.createElement('div');
                                    dateActiviteField.innerHTML = `
                                        <div class="row g-3 mb-4">
                                            <div class="col-12">
                                                <label for="date_activite" class="fw-bold">Date</label>
                                                <input type="date" name="date_activite" class="form-control fw-bold" readonly value="${dateDebut.toISOString().split('T')[0]}">
                                            </div>
                                        </div>
                                    `;
                                    dateActiviteFields.appendChild(dateActiviteField);
                        
                                    for (let hour = 0; hour < 24; hour++) {
                                        const formattedHour = hour.toString().padStart(2, '0');
                                        const debut = `${formattedHour}:00`;
                                        const finHour = (hour + 1) % 24;
                                        const finFormattedHour = finHour.toString().padStart(2, '0');
                                        let fin = `${finFormattedHour}:00`;
                        
                                        var heureActiviteField = document.createElement('div');
                                        heureActiviteField.innerHTML = `
                                            <div class="row g-3 mb-4 ms-4">
                                                <div class="col-sm-4">
                                                    <label for="heure_debut">Heure de début de l'activité</label>
                                                    <input type="time" name="heure_debut" class="form-control" value="${debut}" readonly>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="heure_fin">Heure de fin de l'activité</label>
                                                    <input type="time" name="heure_fin" class="form-control" value="${fin}" readonly>
                                                </div>
                                        
                                                <div class="col-sm-4">
                                                    <label for="nom_activite">Nom de l'activité</label>
                                                    <input type="text" name="nom_activite[]" class="form-control" value="@foreach( $chronogramme as $chronogrammes )  @if(\Carbon\Carbon::parse($chronogrammes->heure_debut)->format('H:i')=='${debut}') {{$chronogrammes->nom_activite}} @endif @endforeach ">
                                                </div>
                                            </div>
                                        `;
                                       dateActiviteFields.appendChild(heureActiviteField);
                                    }                        
                                    // Incrémenter d'un jour
                                    dateDebut.setDate(dateDebut.getDate() + 1);
                                }
                            }
                        </script> --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const toastLiveExample = document.getElementById('liveToast');
        
                                if (toastLiveExample) {
                                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                    toastBootstrap.show();
                                }
                            });
                        </script>
                        <div class="col-12 row">
                            <div class="col">
                                <a href="{{route('evenement.create')}}" class="btn btn-outline-success w-100">Précédent</a>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success w-100">Suivant</button>
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>      
           
            
        </div>
    @endsection