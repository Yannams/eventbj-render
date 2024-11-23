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
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                
                <div class="modal-body">
                    <div class="d-flex justify-content-end w-100">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                  <div class="mt-5"> Voulez-vous abandonner ? si vous abandonner vous devrez reprendre la creation de l'evenement depuis le debut. Vous pouvez enregistrez et Continuer la creation de l'evnement plus tard </div>
                  <div class="d-flex align-items-center mt-5">
                    <div class="flex-grow-1">
                        <button type="button" class="" data-bs-dismiss="modal" style="background-color: #ffffff; border:none">Annuler</button>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-danger" id="GiveUp">Abandonner</button>
                        <button type="button" class="btn btn-success" id="SaveProcess">Enregistrer</button>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
    <div class="card border-0">
        <div class="card-body">
            <form action="{{route('evenement.update', $evenement)}}" method="post" enctype="multipart/form-data" class="m-3 needs-validation" novalidate>
                @csrf
                @method('PUT')
     
                    
                        <div class="col-12 mb-3 d-flex justify-content-center">
                            <label class="custum-file-upload" for="cover_event">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                                </div>
                                <div class="text">
                                    <span class="fs-3">Cliquer pour mettre un image de couverture</span><br>
                                </div>
                                <input type="file" id="cover_event" name="cover_event" accept=".png, .jpeg, .jpg, .JPEG, .JPG, .gif">
                            </label>
                        </div>
                
                     <div class="col-12 mb-3">
                        <input type="hidden" name="evenement_id" value="{{$evenement->id}}" id="evenement_id">
                         <label for="nom_evenement">Nom evenement</label>
                         <input type="text" name="nom_evenement" id="nom_evenement" class="form-control @error('nom_evenement') is-invalid @enderror" value="{{$evenement->nom_evenement}}" required>
                         <div class="invalid-feedback">
                            veuillez donner un nom à votre évènement
                         </div>
                     </div>
                     <div class="col-12 mb-3">
                         <label for="type_evenement_id">Type de l'evenement</label>
                         <select name="type_evenement_id" id="type_evenement_id" class="form-control @error('type_evenement_id') is-invalid @enderror"required>
                            @foreach ($type_evenement as $type_evenements )
                                 <option value="{{$type_evenements->id}}" @if ($evenement->type_evenement_id==$type_evenements->id) selected @endif>{{$type_evenements->nom_type_evenement}}</option>
                            @endforeach 
                             
                         </select>
                         <div class="invalid-feedback">
                            Veuilllez selectionner une option
                         </div>
                     </div>
                     <div class="col-12 mb-3">
                        <label for="type_evenement_id">Categorie de l'evenement</label><br>
                        <div class="p-3 border border-1 rounded-2 InterestContainer">
                            @foreach ($interests as $interest)
                                <input type="checkbox" class="btn-check interest" @if(in_array($interest->id,$EventInterestArray)) checked @endif id="Interest-{{$interest->id}}" value="{{$interest->id}}" name="interest[]" autocomplete="off">
                                <label class="btn btn-outline-success rounded-pill mb-2 interestLabel" for="Interest-{{$interest->id}}">{{$interest->nom_ci}}</label>
                            @endforeach 
                        </div>
                        <div class="invalid-feedback_interest text-danger"></div>
                    </div>

                     <div class="col-12 mb-3">
                        <label for="date_heure_debut">Date et heure de début</label>
                        <input type="datetime-local" name="date_heure_debut" id="date_heure_debut" class="form-control @error('date_heure_debut') is-invalid @enderror" value="{{$evenement->date_heure_debut}}" required>
                        <div class="invalid-feedback">
                            La date de debut doit être supérieur à celle du jour et inférieur à celle de fin
                         </div>
                    </div>
                
                    <div class="col-12 mb-3">
                        <label for="date_heure_fin">Date et heure de fin</label>
                        <input type="datetime-local" name="date_heure_fin" id="date_heure_fin" class="form-control @error('date_heure_fin') is-invalid @enderror" value="{{$evenement->date_heure_fin}}" required>
                        <div class="invalid-feedback">
                            La date de fin doit être supérieur à celle du jour et supérieur à celle de début
                         </div>
                    </div>

                     {{-- <div class="col-12 mb-3">
                         <label for="localisation">Localisation</label>
                         <input type="text" name="localisation" id="localisation" class="form-control @error('localisation') is-invalid @enderror" value="{{$evenement->localisation}}" required>
                         <div class="invalid-feedback">
                            Veuillez mettre une localisation
                         </div>
                     </div> --}}
                     <div class="col-12 mb-3">
                         <label for="description">Description</label>
                         <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" required>{{$evenement->description}}</textarea>
                         <div class="invalid-feedback">
                            Veuillez mettre une description
                         </div>
                     </div>
                     <div></div>
                     <div class="col-12 mb-3 row">
                        <div class="col">
                            <a href="{{route('MesEvenements')}}" class="btn btn-outline-success w-100">Annuler</a>
                        </div>
                         <div class="col">
                            <button type="submit" class="btn btn-success w-100">Modifier</button>  
                         </div>
                           
                     </div>         
            </form>
     
        </div>      
    </div>
    <script>
    (() => {
        'use strict';
    
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');
    
        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    var date1 = $('#date_heure_debut').val();
                    var date2 = $('#date_heure_fin').val();
                    var interests=form.querySelectorAll('.interest');
                    var interestsLabels=form.querySelectorAll('.interestLabel');
                    var InterestContainer=form.querySelector('.InterestContainer');
                    var InterestFeedback=form.querySelector('.invalid-feedback_interest')
                    
                    var isChecked= Array.from(interests).some(interest => interest.checked);
                    if (!isChecked) {
                        interestsLabels.forEach(interestsLabel=>{
                            interestsLabel.classList.replace('btn-outline-success','btn-outline-danger');
                            interestsLabel.classList.add('text-danger');
                            InterestContainer.classList.add('border-danger');
                            InterestFeedback.innerHTML='<i class="bi bi-exclamation-circle"></i> Veuilllez selectionner une option'
                            event.preventDefault();
                            event.stopPropagation();
                        })
                    }
                    
                    var dateDebut = new Date(date1);
                    var dateFin = new Date(date2);
                    var today = new Date();
    
                    dateDebut.setHours(0, 0, 0, 0);
                    dateFin.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);
    
                    if (dateDebut > today && dateFin > today) {
                        if (date1 >= date2) {
                            event.preventDefault();
                            event.stopPropagation();
                            $('#date_heure_debut').addClass('is-invalid');
                            $('#date_heure_fin').addClass('is-invalid');
                        } else {
                            form.classList.add('was-validated');
                        }
                    } else {
                        event.preventDefault();
                        event.stopPropagation();
                        $('#date_heure_debut').addClass('is-invalid');
                        $('#date_heure_fin').addClass('is-invalid');
                    }
                }
            }, false);
            
            form.querySelector('#date_heure_debut').addEventListener('change', () => {
                updateValidationClasses('date_heure_debut');
            });
    
            form.querySelector('#date_heure_fin').addEventListener('change', () => {
                updateValidationClasses('date_heure_fin');
            });
    
            var interestsLabels=form.querySelectorAll('.interestLabel');
            var InterestContainer=form.querySelector('.InterestContainer');
            var InterestFeedback=form.querySelector('.invalid-feedback_interest')

            interestsLabels.forEach(interestLabel=>{
                interestLabel.addEventListener('click', (e)=>{
                   
                    if (interestLabel.classList.contains('btn-outline-danger')){
                        console.log('ok');
    
                        interestsLabels.forEach(interestLabel2=>{
                            interestLabel2.classList.replace('btn-outline-danger','btn-outline-success');
                            interestLabel2.classList.remove('text-danger');
                            InterestContainer.classList.replace('border-danger','border-success');
                            InterestFeedback.innerHTML=""
                        });
                        // interestLabel.classList.replace('btn-outline-success','btn-success');
                    }
                })
            })
            function updateValidationClasses(id) {
                const element = $('#' + id);
                const dateValue = element.val();
                const dateDebut = new Date($('#date_heure_debut').val());
                const dateFin = new Date($('#date_heure_fin').val());
    
                var date = new Date(dateValue);
                date.setHours(0, 0, 0, 0);
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                if (element.hasClass('is-invalid')||element.hasClass('is-valid')) {
    
                if (date >= today) {
                    element.removeClass('is-invalid').addClass('is-valid');
                    if (dateDebut<=dateFin) {
                        $('#date_heure_debut').removeClass('is-invalid is-valid').addClass('is-valid');
                        $('#date_heure_fin').removeClass('is-invalid is-valid').addClass('is-valid');
                    }
                } else {
                    element.removeClass('is-valid').addClass('is-invalid');
                }
            }
            }
        });
    })();
    
    </script>

    <script>
        $(document).ready(function() {
            // Lorsque le champ de fichier change
            $('#cover_event').on('change', function() {
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

        document.querySelectorAll('a').forEach(element => {
                    element.addEventListener('click', function(e) {
                        e.preventDefault();
                        link = this.href;
                        function openModal() {
                            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                            myModal.show();
                        }
                        openModal();

                    })
                });

               
                
                SaveProcessButton=document.getElementById('SaveProcess');
                SaveProcessButton.addEventListener('click',function(e){
                    console.log(link);  
                    window.location.href = link;
                })
                GiveUpProcessButton=document.getElementById('GiveUp');
                evenement_id_input=document.getElementById('evenement_id')
                evenement_id=evenement_id_input.value;
                GiveUpProcessButton.addEventListener('click',function (e) {
                    console.log(evenement_id);
                    
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/GiveUpEventProcess',
                    data: {
                        evenement_id: evenement_id,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        window.location.href=link
                    }
                });
            })

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
