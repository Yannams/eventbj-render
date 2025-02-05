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

        <div class="container mt-5">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="{{route('Promoteur.store')}}" method="POST" onsubmit="disableSubmitButton(this)">
                        @csrf
                        <div class="row g-3">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2">
                                <div class="col p-3">
                                    <input type="radio" class="btn-check col" name="type_organisateur" id="personnel" autocomplete="off" checked value="individuel" >
                                    <label class="btn btn-outline-success h-100" for="personnel"> 
                                        <div><svg class="bi bi-person me-1" fill="currentColor"  width="50" height="50"><use xlink:href="#person"></use></svg> </div>
                                        <h5> Pour moi-même </h5>
                                        <p>Ce compte est pour moi et j'y ajouterai les évènements que j'organise moi même</p>
                                    </label>
                                </div>
                                <div class="col p-3">
                                    <input type="radio" class="btn-check col" name="type_organisateur" id="Entreprise" autocomplete="off" value="Entreprise">
                                    <label class="btn btn-outline-success w-100 h-100" for="Entreprise" >
                                       <div><svg class="bi bi-building me-1" fill="currentColor"  width="50" height="50"><use xlink:href="#building"></use></svg> </div>
                                       <h5> Entreprise </h5>
                                       <p>Ce compte est pour une entreprise qui organise des évènements</p>
                                    </label>
                                </div>
                            </div>
                            @error('type_organisateur')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
        
                            <div>
                                <label for="pseudo">Pseudo</label>
                                <input type="text" name="pseudo" id="pseudo" class="form-control @error('pseudo') is-invalid @enderror">
                                @error('pseudo')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" id="submitButton" class="btn btn-success col">Suivant</button> 
                        </div>
                    </form>
                </div>
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
            function disableSubmitButton(form) {
                form.querySelector('#submitButton').disabled = true;
            }
        </script>
    @endsection