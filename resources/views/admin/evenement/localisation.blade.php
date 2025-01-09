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
        @include('layout.stepform')
        <div class="card border-0">
            <div class="card-title fs-3 fw-bold d-flex d-md-none ">Localisation</div>
            <div class="card-body">
                <form action="{{route('localisationStore')}}" method="POST" onsubmit="disableSubmitButton(this)">
                    @csrf
                    <div class="col-12 mb-3">
                        <input type="hidden" name="evenement_id" id="evenement_id" value="{{session('evenement_id')}}">
                        <label for="localisation">{{$evenement->type_lieu->nom_type=='physique'?'Indication':'Application de l\'évènement'}}</label>
                        <input type="text" name="localisation" id="localisation" class="form-control @error('localisation') is-invalid @enderror" value="{{$evenement->localisation}}">
                        @error('localisation')
                            <div class="invalid-feedback">
                               {{$message}}
                            </div>
                        @enderror
                    </div>
                    @if ($evenement->type_lieu->nom_type=='physique')

                        <div class="mb-2">
                                Pour créer la localisation google maps.
                                <ul class="list-unstyled ms-3">
                                    <li><i class="bi bi-1-circle me-2 text-success"></i> Allez sur <a href="https://www.google.com/maps" target="_blank" class="link-success">google maps</a>    </li>
                                    <li><i class="bi bi-2-circle me-2 text-warning"></i> Recherchez le lieu en question</li>
                                    <li><i class="bi bi-3-circle me-2 text-danger"></i> Cliquez sur partager </li>
                                    <li><i class="bi bi-4-circle me-2 text-success"></i> Cliquez sur insérer une carte</li>
                                    <li><i class="bi bi-5-circle me-2 text-warning"></i> Cliquez sur copier le contenu html</li>
                                    <li><i class="bi bi-6-circle me-2 text-danger"></i> Collez dans la zone de texte en bas</li>
                                </ul>
                        
                        </div>
                        <div class="col-12 mb-3">
                            <label for="localisation_maps">Localisation maps</label>
                            <input type="text" name="localisation_maps" id="localisation_maps" class="form-control @error('localisation_maps') is-invalid @enderror" value="{{$evenement->localisation_maps}}">
                            @error('localisation_maps')
                                <div class="invalid-feedback">
                                   {{$message}}
                                </div>
                            @enderror
                        </div>
                    @endif 

                    <div class="col-12 mb-3 row">
                        <div class="col">
                            <a href="{{route('select_type_lieu')}}" class="btn btn-outline-success w-100">Précédent</a>
                        </div>
                         <div class="col">
                            <button type="submit" id="submitButton" class="btn btn-success w-100">Suivant</button>  
                         </div>
                           
                     </div>   
                </form>
            </div>
        </div>  
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastLiveExample = document.getElementById('liveToast');
  
                if (toastLiveExample) {
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                    toastBootstrap.show();
                }
            });
           

            document.querySelectorAll('a').forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    link = this.href;
                    console.log(link);
                    
                    function openModal() {
                        var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                        myModal.show();
                    }
                    openModal();

                })
            });

           
            
            SaveProcessButton=document.getElementById('SaveProcess');
            SaveProcessButton.addEventListener('click',function(e){
                window.location.href = link;
            })
            GiveUpProcessButton=document.getElementById('GiveUp'); 
            evenement_id_input=document.getElementById('evenement_id')
            evenement_id=evenement_id_input.value;
            GiveUpProcessButton.addEventListener('click',function (e) {
                
                
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
                    let editLink = "{{ route('evenement.edit', ':id') }}";
                    editLink = editLink.replace(':id', evenement_id); 
                    if (link === editLink) {
                        link = "{{ route('Create_event') }}";
                    }
                    window.location.href=link
                }
            });
        })

        function disableSubmitButton(form) {
            form.querySelector('#submitButton').disabled = true;
        }
    </script>  
    @endsection