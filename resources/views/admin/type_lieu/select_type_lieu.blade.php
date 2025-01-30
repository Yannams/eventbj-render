@extends('layout.promoteur')
    @section('content')
    @include('layout.stepform')
    @error('type_lieu_event')
        <div class="position-relative">
            <div class="toast-container position-fixed bottom-0 end-0 translate-middle p-3 ">
                <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body d-flex align-items-center">
                        <div class="p-2">
                            <svg class="bi bi-check-all" fill="#fff" width="30" height="30">
                                <use xlink:href="#error"></use>
                            </svg>
                        </div>
                        <div class="p-2 fw-bold ">Veuillez selectionner un type de lieu</div>
                        <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>    
        </div>
    @enderror
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
            <div class="row align-items-center">
                <form action="{{route('typelieuSelected')}}" method="post">
                    @csrf 
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                                <div class="col">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        @foreach ($type_lieu as  $type_lieus )
                                        <div class="col">
                                            <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement_id}}">
                                            <input type="radio" class="hidden-radio" name="type_lieu_event" id="{{$type_lieus->nom_type}}"  value="{{$type_lieus->id}}" autocomplete="off">
                                            <label class="@error('type_lieu_event') button-check-error @else button-check @enderror w-100 h-100" for="{{$type_lieus->nom_type}}">
                                                <h5>{{$type_lieus->nom_type}}</h5>
                                                <p>{{$type_lieus->description}}</p>
                                            </label>
                                        </div>    
                                    @endforeach
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success w-100">Suivant</button>
                                </div>
                            </div>
                           
                        </div>    
                    </div>              
                    
                  
                </form>
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
                        window.location.href=link
                    }
                });
            })
            </script>
           
    @endsection