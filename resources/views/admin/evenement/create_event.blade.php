@extends('layout.promoteur')
    @section('content')
    @include('layout.stepform')
    @error('Frequence')
        <div class="position-relative">
            <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
                <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body d-flex align-items-center">
                        <div class="p-2">
                            <svg class="bi bi-check-all" fill="#fff" width="30" height="30">
                                <use xlink:href="#error"></use>
                            </svg>
                        </div>
                        <div class="p-2 fw-bold fs-5">Veuillez selectionner une frequence</div>
                        <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>    
        </div>
    @enderror
  
        <div class="row align-items-center">
            <form action="{{route('evenement.store')}}" method="post" onsubmit="disableSubmitButton(this)"> 
                @csrf
              
                <div class="card border-0">
                    <div class="card-body">
                        <div class="card-title fs-3 fw-bold d-flex d-md-none ">Fréquence</div>
                        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                            <div class="col">

                            </div>
                            <div class="col">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        <div class="col">
                                            <input type="radio" class="hidden-radio" name="Frequence" id="unique" autocomplete="off" value="unique" >
                                            <label class=" @error('Frequence') button-check-error @else button-check @enderror w-100 h-100" for="unique">
                                                <h5>Une seule fois</h5>
                                                <p>Evènement qui se produit une seule fois </p>
                                            </label>
                                        </div>      
                                        <div class="col">
                                            <input type="radio" class="hidden-radio" name="Frequence" id="multiple" autocomplete="off" value="multiple" >
                                            <label class="@error('Frequence') button-check-error @else button-check @enderror  w-100 h-100" for="multiple">
                                                <h5>Plusieurs fois</h5>
                                                <p>Evènement qui se produit plusieurs fois avec plusieurs éditions</p>
                                            </label>
                                        </div>        
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success w-100" id="submitButton">Suivant</button>
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

            function disableSubmitButton(form) {
                form.querySelector('#submitButton').disabled = true;
            }
        </script>
    @endsection