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
    <div class="modal fade" id="cropAvatarmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel">Recadrer image</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="img-container">
                <img id="uploadedAvatar" src="https://avatars0.githubusercontent.com/u/3456749">
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Annuler</button>
                <button type="button" class="btn btn-primary" id="crop">Recadrer</button>
            </div>
          </div>
        </div>
      </div>
   @include('layout.stepform')
    <div class="card border-0">
        <div class="card-body">
            <div class="card-title fs-3 fw-bold d-flex d-md-none ">Création de ticket</div>
            <form action="{{route('type_ticket.store')}}" method="post" enctype="multipart/form-data"  onsubmit="disableSubmitButton(this)">

                @csrf
                <div class="row g-3">
                    <div class="col-12 ">
                        <div class="col-12 mb-3 d-flex justify-content-center">
                            <label class="custum-file-upload" for="image_ticket" style="@error('image_ticket') border:solid 0.5px #F0343C @enderror">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                                </div>
                                <div class="text">
                                    <span class="fs-3">Cliquer pour mettre une image de couverture</span><br>
                                    @error('image_ticket') <span class="fs-3 text-danger">{{$message}}</span><br> @enderror
                                </div>
                                <input type="file" id="image_ticket" name="image_ticket" accept=".png, .jpeg, .jpg, .JPEG, .JPG" >
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="croppedCover" id="croppedCover">
                    <div class="col-6 ">
                        <label for="nom_ticket">Nom ticket</label>
                        <input type="text" name="nom_ticket" id="nom_ticket" class="form-control @error('nom_ticket') is-invalid @enderror" value="{{old('nom_ticket')}}" >
                        @error('nom_ticket')
                            <div class="invalid-feedback">
                               {{$message}}
                            </div>
                        @enderror  
                    </div>
                    <div class="col-6">
                        <label for="format">Format</label>
                        <select name="format" id="format" class="form-select  @error('format') is-invalid @enderror">
                            <option value="Ticket" @if (old('format')=='Ticket') selected @endif>Ticket</option>
                            <option value="Invitation" @if (old('format')=='Invitation') selected @endif>Invitation</option>
                        </select>
                        @error('format')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror 
                    </div>
                    <div class="format_input_container row g-3 w-100">
                        <div class="col-sm-6">
                            <label for="prix_ticket">Prix ticket</label>
                            <input type="number" name="prix_ticket" id="prix_ticket" class="form-control @error('prix_ticket') is-invalid @enderror"  min="0" value="{{old('prix_ticket')}}">
                            @error('prix_ticket')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror 
                        </div>
                        {{-- <div class="col-sm-4">
                            <label for="frais_ticket">frais prélevée</label>
                            <input type="number" name="frais_ticket" id="frais_ticket" class="form-control" min="0" readonly>
                            <div class="invalid-feedback">
                                Impossible de calculer les frais de ticket
                            </div>
                        </div> --}}
                       
                        <div class="col-sm-6">
                            <label for="place_dispo">Quantité de ticket</label>
                            <input type="number" name="place_dispo" id="place_dispo" class="form-control @error('place_dispo') is-invalid @enderror" value="{{old('place_dispo')}}">
                            @error('place_dispo')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror 
                        </div>

                        @if ($evenement->type_lieu->nom_type == "En ligne")
                            <div class="col-sm-12">
                                <label for="event_link">Lien de l'évènement</label>
                                <input type="text" name="event_link" id="event_link" class="form-control @error('event_link') is-invalid @enderror" value="{{old('event_link')}}" >
                                @error('event_link')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror 
                            </div>
                        @endif
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
                       <select name="methodeProgrammationLancement" id="methodeProgrammationLancement" class="form-select @error('methodeProgrammationLancement') is-invalid @enderror">
                            <option value=""></option>
                            <option value="ActivationEvènement" @if (old('methodeProgrammationLancement')=='ActivationEvènement') selected @endif>Au moment où l'évènement est activé</option>
                            <option value="ProgrammerBilleterie" @if (old('methodeProgrammationLancement')=='ProgrammerBilleterie') selected @endif>Programmer ...</option>
                            <option value="ProgrammerPlustard" @if (old('methodeProgrammationLancement')=='ProgrammerPlustard') selected @endif>Programmer plus tard</option>
                       </select>
                       @error('methodeProgrammationLancement')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror 
                    </div>
                    <div id="programmerLancement" class="col-12">
                        
                    </div>
                    @error('Date_heure_lancement')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror 
                    <div class="col-12">
                        <label for="methodeProgrammationFermeture">Date de fermeture de la billetterie</label>
                       <select name="methodeProgrammationFermeture" id="methodeProgrammationFermeture" class="form-select @error('methodeProgrammationFermeture') is-invalid @enderror">
                            <option value=""></option>
                            <option value="FinEvenement" @if (old('methodeProgrammationFermeture')=='FinEvenement') selected @endif>Date de fin de l'evenement</option>
                            <option value="ProgrammerFermeture" @if (old('methodeProgrammationFermeture')=='ProgrammerFermeture') selected @endif>Programmer ...</option>
                            <option value="ProgrammerPlustard" @if (old('methodeProgrammationFermeture')=='ProgrammerPlustard') selected @endif>Programmer plus tard</option>
                       </select>
                       @error('methodeProgrammationFermeture')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror 
                    </div>
                    <div id="programmerFermeture">

                    </div>
                    @error('Date_heure_fermeture')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror 
                    <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement_id}}">
                    <div class="col-12 mt-4 row">
                        <div class="col">
                            <a href="" class="btn btn-outline-success w-100">Précédent</a>
                        </div>
                        <div class="col">
                            <button type="submit" id="submitButton" class="btn btn-success w-100">suivant</button>
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
            <script>
                $('#methodeProgrammationLancement').change(function programmerLancement() {
                    DateVal=$(this).val();
                    if(DateVal==="ProgrammerBilleterie"){
                       $('#programmerLancement').html("<label for=\"Date_heure_lancement\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_lancement\" id=\"Date_heure_lancement\" class=\"form-control @error('Date_heure_lancement') is-invalid @enderror\" value=\"{{old('Date_heure_lancement')}}\">")
                    }else{
                        $('#programmerLancement').html("")
                    }
                })

                $('#methodeProgrammationFermeture').change(function programmerFermeture() {
                    DateVal=$(this).val();
                    if(DateVal==="ProgrammerFermeture"){ 
                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control @error('Date_heure_fermeture') is-invalid @enderror\" value=\"{{old('Date_heure_fermeture')}}\">");
                    }else if(DateVal==="FinEvenement"){
                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control\" readonly value=\"{{$evenement->date_heure_fin}}\">");
                    }else{
                        $('#programmerFermeture').html("");
                    }
                })
            </script>
            {{-- <script>
                var prix_ticket_input=document.getElementById('prix_ticket');
                var frais_ticket_input=document.getElementById('frais_ticket');
                prix_ticket_input.addEventListener('input',function calulFrais() {
                    var prix_ticket= prix_ticket_input.value
                    var frais_ticket=prix_ticket*0.1
                   frais_ticket_input.value=frais_ticket
                })
            </script> --}}
            <script>
                var format=document.querySelector('#format')
                var formatContainer= document.querySelector('.format_input_container');
                
                format.addEventListener('change',function (e) {
                   if (format.value=="Invitation") {
                    formatContainer.innerHTML=`
                     <div class="col-12">
                            <label for="texte">Texte</label>
                            <Textarea id="texte" class="form-control" name="texte"></Textarea>
                            <div class="invalid-feedback">
                                Veuillez entrez un texte descriptif
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="place_dispo">Quantité d'invitation</label>
                            <input type="number" name="place_dispo" id="place_dispo" class="form-control"  required>
                            <div class="invalid-feedback">
                                Veuillez ajouter une quantité
                            </div>
                        </div>`
                   }else if(format.value=="Ticket"){
                        formatContainer.innerHTML=`
                            <div class="col-sm-6">
                                <label for="prix_ticket">Prix ticket</label>
                                <input type="number" name="prix_ticket" id="prix_ticket" class="form-control"  min="0" required>
                                <div class="invalid-feedback">
                                    Veuillez mettre le prix du ticket
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="place_dispo">Quantité de ticket</label>
                                <input type="number" name="place_dispo" id="place_dispo" class="form-control"  required>
                                <div class="invalid-feedback">
                                    Veuillez ajouter une quantité
                                </div>
                            </div>
                        `
                   }
                   
                
                    
                })
                function disableSubmitButton(form) {
                    form.querySelector('#submitButton').disabled = true;
                }

                document.addEventListener('DOMContentLoaded',function () {
                    
                    
                    if ($('#methodeProgrammationLancement').val()=='ProgrammerBilleterie') {
                       $('#programmerLancement').html("<label for=\"Date_heure_lancement\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_lancement\" id=\"Date_heure_lancement\" class=\"form-control @error('Date_heure_fermeture') is-invalid @enderror\" value=\"{{old('Date_heure_lancement')}}\">")
                    }

                    if($('#methodeProgrammationFermeture').val()==="ProgrammerFermeture"){ 

                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control @error('Date_heure_fermeture') is-invalid @enderror\" value=\"{{old('Date_heure_fermeture')}}\">");
                    }else if($('#methodeProgrammationFermeture').val()==="FinEvenement"){
                        $('#programmerFermeture').html("<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture\" id=\"Date_heure_fermeture\" class=\"form-control\" readonly value=\"{{$evenement->date_heure_fin}}\">");
                    }
                })
                window.addEventListener('DOMContentLoaded', function () {
                var avatar = document.getElementById('profile-img');
                var image = document.getElementById('uploadedAvatar');
                var input = document.getElementById('image_ticket');
                var cropBtn = document.getElementById('crop');
                var $modal = $('#cropAvatarmodal');
                var cropper;

                $('[data-toggle="tooltip"]').tooltip();

                input.addEventListener('change', function (e) {
                    var files = e.target.files;
                    var done = function (url) {
                    // input.value = '';
                    
                    image.src = url;
                    $modal.modal('show');
                    };
                    // var reader;
                    // var file;
                    // var url;

                    if (files && files.length > 0) {
                    let file = files[0];

                        // done(URL.createObjectURL(file));
                    // if (URL) {
                    // } 
                    
                    // else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                        done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    // }
                    }
      });
      
      
      

      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          aspectRatio: 16 / 9,
          viewMode: 3,
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      cropBtn.addEventListener('click', function () {
        cropper.getCroppedCanvas().toBlob((blob) => {
            const reader = new FileReader();

            reader.onloadend = () => {
                // Mettre l'image recadrée en Base64 dans l'input caché
                document.getElementById('croppedCover').value = reader.result;

                // Fermer le modal
                
                $modal.modal('hide');
            };

            reader.readAsDataURL(blob);
        });
      });
      
    }); 
            </script>
    </div>
    @endsection