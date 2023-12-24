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
            <a href="" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
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
            <form action="{{route('type ticket.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12 ">
                        <label for="image_ticket">Choisir un cover pour les tickets</label>
                        <input type="file" name="image_ticket" id="image_ticket" class="form-control">
                    </div>
                    <div class="col-12 ">
                        <label for="nom_ticket">Nom ticket</label>
                        <input type="text" name="nom_ticket" id="nom_ticket" class="form-control">
                    </div>
                    <div class="col-2">
                        <label for="type_ticket">type_ticket</label>
                        <select name="type_ticket" id="type_ticket" class="form-control">
                            <option value="ticket payé">ticket payé</option>
                            <option value="Invitation">Invitation</option>
                            <option value="Don">Don</option>

                        </select>
                    </div>
                
                    <div class="col-sm-4">
                        <label for="prix_ticket">Prix ticket</label>
                        <input type="number" name="prix_ticket" id="prix_ticket" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label for="frais_ticket">frais prélevée</label>
                        <input type="number" name="frais_ticket" id="frais_ticket" class="form-control">
                    </div>
                    
                    <div class="col-sm-4">
                        <label for="place_dispo">Nombre de place</label>
                        <input type="number" name="place_dispo" id="place_dispo" class="form-control" >
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