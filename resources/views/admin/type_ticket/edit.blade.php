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
    <div class="card border-0">
        <div class="card-body">
            
            <form action="{{route('type_ticket.update',$type_ticket->id)}}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    {{-- <div class="col-12 ">
                      <label for="image_ticket">Choisir un cover pour les tickets</label>
                      <input type="file" name="image_ticket" id="image_ticket" class="form-control" required>
                        <div class="invalid-feedback">
                            Veuillez ajouter une image de couverture
                        </div>
                    </div> --}}
                    <div class="col-12 mb-3 d-flex justify-content-center">
                        <label class="custum-file-upload" for="image_ticket">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text">
                                <span class="fs-3">Cliquer pour mettre un image de couverture</span><br>
                            </div>
                            <input type="file" id="image_ticket" name="image_ticket">
                        </label>
                    </div>
                    <div class="col-12 ">
                        <label for="nom_ticket">Nom ticket</label>
                        <input type="text" name="nom_ticket" id="nom_ticket" class="form-control" minlength="3" maxlength="100" required value="{{$type_ticket->nom_ticket}}">
                        <div class="invalid-feedback">
                            Veuillez entrer un nom d'au moins 3 caractères
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="type_ticket">type_ticket</label>
                        <select name="type_ticket" id="type_ticket" class="form-control" required>
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
                        <input type="number" name="prix_ticket" id="prix_ticket" class="form-control"  min="0" required value="{{$type_ticket->prix_ticket}}">
                        <div class="invalid-feedback">
                            Veuillez mettre le prix du ticket
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="frais_ticket">frais prélevée</label>
                        <input type="number" name="frais_ticket" id="frais_ticket" class="form-control" min="0" value="{{$type_ticket->frais_ticket}}">
                        <div class="invalid-feedback">
                            Veuillez ajouter le prix du ticket
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <label for="place_dispo">Quantité de ticket</label>
                        <input type="number" name="place_dispo" id="place_dispo" class="form-control"  required value="{{$type_ticket->place_dispo}}">
                        <div class="invalid-feedback">
                            Veuillez ajouter une quantité
                        </div>
                    </div>
        
                    {{-- <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement_id}}"> --}}
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
        
         $(document).ready(function() {
            // Lorsque le champ de fichier change
            $('#image_ticket').on('change', function() {
                var input = this;
                var label = $(input).parent('.custum-file-upload');
                var imagePreview = label.find('.icon');

                var fileName = input.files[0].name;
    
                // Afficher le nom du fichier dans le label
                label.find('.text span').text('Cliquer pour modifier');
               // label.find('.text .edit-text').text('Cliquer pour modifier');
    
                // Charger l'image sélectionnée comme fond du label
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Mettre à jour le src de l'image
                    label.css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'cover'
                    }); 
                };
                reader.readAsDataURL(input.files[0]);
    
                // Mettre à jour la bordure du label (facultatif)
                label.css('border-color', 'transparent');
            });
        });
    </script>
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
    </div>
    @endsection