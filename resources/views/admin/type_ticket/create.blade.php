@extends('layout.promoteur')
    @section('content')
    <div class="container">
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
   @include('layout.stepform')
    <div class="card border-0">
        <div class="card-body">
            <form action="{{route('type_ticket.store')}}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">

                @csrf
                <div class="row g-3">
                    <div class="col-12 ">
                      <label for="image_ticket">Choisir un cover pour les tickets</label>
                      <input type="file" name="image_ticket" id="image_ticket" class="form-control" required>
                        <div class="invalid-feedback">
                            Veuillez ajouter une image de couverture
                        </div>
                    </div>
                    <div class="col-12 ">
                        <label for="nom_ticket">Nom ticket</label>
                        <input type="text" name="nom_ticket" id="nom_ticket" class="form-control" minlength="3" maxlength="100" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un nom d'au moins 3 caractères
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="type_ticket">type_ticket</label>
                        <select name="type_ticket" id="type_ticket" class="form-select" required>
                            <option value="ticket payé">ticket payé</option>
                            <option value="Invitation">Invitation</option>
                            <option value="Don">Don</option>
                        </select>
                        <div class="invalid-feedback">
                            Veuillez choisir une categorie de ticket 
                        </div>
                    </div>
                
                    <div class="col-sm-4">
                        <label for="prix_ticket">Prix ticket</label>
                        <input type="number" name="prix_ticket" id="prix_ticket" class="form-control"  min="0" required>
                        <div class="invalid-feedback">
                            Veuillez mettre le prix du ticket
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="frais_ticket">frais prélevée</label>
                        <input type="number" name="frais_ticket" id="frais_ticket" class="form-control" min="0" required readonly>
                        <div class="invalid-feedback">
                            Impossible de calculer les frais de ticket
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <label for="place_dispo">Quantité de ticket</label>
                        <input type="number" name="place_dispo" id="place_dispo" class="form-control"  required>
                        <div class="invalid-feedback">
                            Veuillez ajouter une quantité
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4"><hr></div>
                        <div class="col-4 d-flex justify-content-center">
                            <div class="fw-bold">Programmer la billetterie</div>
                        </div>
                        <div class="col-4"><hr></div>
                    </div>
                    <div class="col-12">
                        <label for="methodeProgrammationLancement">Date d'ouverture de la billetterie</label>
                       <select name="methodeProgrammationLancement" id="methodeProgrammationLancement" class="form-select" required>
                            <option value=""></option>
                            <option value="ActivationEvènement">Au moment où l'évènement est activé</option>
                            <option value="ProgrammerBilleterie">Programmer ...</option>
                            <option value="ProgrammerPlustard">Programmer plus tard</option>
                       </select>
                    </div>
                    <div id="programmerLancement" class="col-12">
                        
                    </div>
                    <div class="col-12">
                        <label for="methodeProgrammationFermeture">Date de fermeture de la billetterie</label>
                       <select name="methodeProgrammationFermeture" id="methodeProgrammationFermeture" class="form-select" required>
                            <option value=""></option>
                            <option value="FinEvenement">Date de fin de l'evenement</option>
                            <option value="ProgrammerFermeture">Programmer ...</option>
                            <option value="ProgrammerPlustard">Programmer plus tard</option>
                       </select>
                    </div>
                    <div id="programmerFermeture">

                    </div>
                    <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement_id}}">
                    <div class="col-12 mt-4 row">
                        <div class="col">
                            <a href="" class="btn btn-outline-success w-100">Précédent</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success w-100">suivant</button>
                        </div>
                    </div>  
                </div>
                
            </form> 
        </div>
    </div>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)
            })
            })()
    </script>
       
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastLiveExample = document.getElementById('liveToast');

                    if (toastLiveExample) {
                        const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                        toastBootstrap.show();
                    }
                });
            </script>
            <script>
                $('#methodeProgrammationLancement').change(function programmerLancement() {
                    DateVal=$(this).val()
                    console.log(DateVal);
                    if(DateVal==="ProgrammerBilleterie"){
                       $('#programmerLancement').html("<label for=\"Date_heure_lancement\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_lancement\" id=\"Date_heure_lancement\" class=\"form-control\">")
                    }else{
                        $('#programmerLancement').html("")
                    }
                })

                $('#methodeProgrammationFermeture').change(function programmerFermeture() {
                    DateVal=$(this).val()
                    console.log(DateVal);
                    if(DateVal==="ProgrammerFermeture"){ 
                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control\">");
                    }else if(DateVal==="FinEvenement"){
                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control\" value=\"{{$evenement->date_heure_fin}}\">");
                    }else{
                        $('#programmerFermeture').html("");
                    }
                })
            </script>
            <script>
                var prix_ticket_input=document.getElementById('prix_ticket');
                var frais_ticket_input=document.getElementById('frais_ticket');
                prix_ticket_input.addEventListener('input',function calulFrais() {
                    var prix_ticket= prix_ticket_input.value
                    var frais_ticket=prix_ticket*0.1
                   frais_ticket_input.value=frais_ticket
                })
            </script>
    </div>
    @endsection